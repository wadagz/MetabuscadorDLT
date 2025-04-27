<?php

namespace App\Services;

use App\Models\User;
use App\Models\Hospedaje;
use App\Models\Amenidad;
use App\Models\TipoHospedaje;
use App\Enums\PreferenciaEnum;
use App\Enums\AmenidadEnum;
use App\Enums\TipoHospedajeEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

class RecommendationService
{
    /**
     * Number of clusters for K-means algorithm
     */
    protected int $numClusters = 3;

    /**
     * Maximum number of iterations for K-means
     */
    protected int $maxIterations = 100;

    /**
     * Get recommended hospedajes for a user based on their preferences
     *
     * @param User $user The user to get recommendations for
     * @param int $destinoId The destination ID to filter recommendations
     * @param int $limit The maximum number of recommendations to return
     * @return Collection The recommended hospedajes
     */
    public function getRecommendedHospedajes(User $user, int $destinoId, int $limit = 5): Collection
    {
        // Get all hospedajes for the destination
        $hospedajes = Hospedaje::where('destino_id', $destinoId)
            ->with(['amenidades'])
            ->get();

        if ($hospedajes->isEmpty()) {
            return collect([]);
        }

        // En lugar de usar el método pluck, obtenemos las preferencias con una consulta específica
        $userPreferenceIds = \DB::table('preferencias_usuarios')
            ->where('user_id', $user->id)
            ->join('preferencias', 'preferencias.id', '=', 'preferencias_usuarios.preferencia_id')
            ->select('preferencias.id')
            ->pluck('id')
            ->toArray();

        if (empty($userPreferenceIds)) {
            // If user has no preferences, return random hospedajes
            return $hospedajes->random(min($limit, $hospedajes->count()));
        }

        // Prepare data for clustering
        $hospedajeFeatures = $this->prepareHospedajeFeatures($hospedajes, $userPreferenceIds);

        // Run K-means clustering
        $clusters = $this->kMeansClustering($hospedajeFeatures);

        // Find the best cluster for the user
        $userVector = $this->createUserVector($userPreferenceIds);
        $bestCluster = $this->findBestClusterForUser($userVector, $clusters);

        // Get hospedajes from the best cluster
        $recommendedHospedajes = collect([]);
        foreach ($clusters[$bestCluster]['members'] as $hospedajeIndex) {
            $recommendedHospedajes->push($hospedajes[$hospedajeIndex]);
        }

        // If not enough recommendations, add from other clusters
        if ($recommendedHospedajes->count() < $limit) {
            $remainingHospedajes = $hospedajes->whereNotIn('id', $recommendedHospedajes->pluck('id'));
            $additionalRecommendations = $remainingHospedajes->sortBy(function($hospedaje) use ($userVector) {
                return $this->calculateDistance($this->hospedajeToVector($hospedaje, $userVector), $userVector);
            })->take($limit - $recommendedHospedajes->count());

            $recommendedHospedajes = $recommendedHospedajes->concat($additionalRecommendations);
        }

        return $recommendedHospedajes->take($limit);
    }

    /**
     * Obtener lista de recomendaciones para un usuario en un destino.
     * @param User $user El usuario para el cual obtener recomendaciones.
     * @param int $destinoId El ID del Destino donde se busca hospedaje.
     * @param int $limit Cantidad máxima de resultados para mostrar.
     * @return Collection Los hospedajes recomendados.
     */
    public function getRecommendationsForSearchingHospedaje(User $user, int $destinoId, int $limit = 50): Collection
    {
        $allHospedajes = Hospedaje::where('destino_id', $destinoId)
            ->with([
                'direccion',
                'amenidades',
                'usuariosQueDieronFavorito' => function ($query) use ($user) {
                    $query->where('id', $user->id);
                }
            ])->get();

        $userPreferenceIds = DB::table('preferencias_usuarios')
            ->where('user_id', $user->id)
            ->join('preferencias', 'preferencias.id', '=', 'preferencias_usuarios.preferencia_id')
            ->select('preferencias.id')
            ->pluck('id')
            ->toArray();

        if (empty($userPreferenceIds)) {
            // If user has no preferences, return random hospedajes
            return $allHospedajes->random(min($limit, $allHospedajes->count()));
        }

        // Create user preference vector
        $userVector = $this->createUserVector($userPreferenceIds);

        // Calculate compatibility score for each hospedaje
        foreach ($allHospedajes as $hospedaje) {
            $hospedajeVector = $this->hospedajeToVector($hospedaje, $userPreferenceIds);
            $distance = $this->calculateDistance($hospedajeVector, $userVector);
            $maxDistance = sqrt(count($userVector));

            // Convert distance to a score (0-100), higher is better
            $compatibilityScores[$hospedaje->id] = round((1 - ($distance / $maxDistance)) * 100);
        }

        // Sort hospedajes by compatibility score (highest first)
        $allHospedajes = $allHospedajes->sortByDesc(function($hospedaje) use ($compatibilityScores) {
            return $compatibilityScores[$hospedaje->id] ?? 0;
        });

        // Obtiene los primeros $limit hospedajes de la colección ordenada
        $recommendedHospedajes = $allHospedajes->take($limit)->values();

        return $recommendedHospedajes;
    }

    /**
     * Obtener lista de hospedajes similares a un hospedaje concreto.
     * @param User $user El usuario para el cual obtener recomendaciones.
     * @param Hospedaje $hospedaje El hospedaje para el cual se buscan similitudes.
     * @param int $limit Cantidad máxima de resultados para mostrar.
     * @return Collection Los hospedajes similares.
     */
    public function getSimilarHospedajes(User $user, Hospedaje $hospedaje, int $limit = 10): Collection
    {
        $userPreferenceIds = DB::table('preferencias_usuarios')
            ->where('user_id', $user->id)
            ->join('preferencias', 'preferencias.id', '=', 'preferencias_usuarios.preferencia_id')
            ->select('preferencias.id')
            ->pluck('id')
            ->toArray();

        $similarHospedajes = collect([]);
        $compatibilityScores = [];

        // Get similar hospedajes
        $similarHospedajesQuery = Hospedaje::where('destino_id', $hospedaje->destino_id)
            ->where('id', '!=', $hospedaje->id)
            ->with(['amenidades', 'direccion']);

        if (empty($userPreferenceIds)) {
            // If no preferences, get random similar hospedajes
            return $similarHospedajesQuery->inRandomOrder()->limit($limit)->get();
        }

        $userVector = $this->createUserVector($userPreferenceIds);
        $allSimilarHospedajes = $similarHospedajesQuery->get();

        // Calculate compatibility for each similar hospedaje
        foreach ($allSimilarHospedajes as $similarHospedaje) {
            $hospedajeVector = $this->hospedajeToVector($similarHospedaje, $userPreferenceIds);
            $distance = $this->calculateDistance($hospedajeVector, $userVector);
            $maxDistance = sqrt(count($userVector));
            $compatibilityScores[$similarHospedaje->id] = round((1 - ($distance / $maxDistance)) * 100);
        }

        // Sort by compatibility and take top 3
        $similarHospedajes = $allSimilarHospedajes->sortByDesc(function($h) use ($compatibilityScores) {
            return $compatibilityScores[$h->id] ?? 0;
        })->take($limit)->values();

        return $similarHospedajes;
    }

    /**
     * Prepare hospedaje features for K-means clustering
     *
     * @param Collection $hospedajes The hospedajes to extract features from
     * @param array $userPreferences The user's preference IDs
     * @return array Array of hospedaje feature vectors
     */
    protected function prepareHospedajeFeatures(Collection $hospedajes, array $userPreferences): array
    {
        $features = [];

        foreach ($hospedajes as $index => $hospedaje) {
            $features[$index] = $this->hospedajeToVector($hospedaje, $userPreferences);
        }

        return $features;
    }

    /**
     * Convert a hospedaje to a feature vector based on amenities and type
     *
     * @param Hospedaje $hospedaje The hospedaje to convert
     * @param array $userPreferences The user's preference IDs
     * @return array The feature vector
     */
    public function hospedajeToVector(Hospedaje $hospedaje, array $userPreferences): array
    {
        $vector = [];

        // Initialize vector with zeros for all possible preference values
        foreach (PreferenciaEnum::cases() as $preference) {
            $vector[$preference->value] = 0;
        }

        // Map amenities to preference vectors
        foreach ($hospedaje->amenidades as $amenidad) {
            $preferenceValue = $this->mapAmenidadToPreferencia($amenidad->id);
            if ($preferenceValue) {
                $vector[$preferenceValue] = 1;
            }
        }

        // Map hospedaje type to atmosphere preferences (Question 1)
        $tipoPreferenceValue = $this->mapTipoHospedajeToPreferencia($hospedaje->tipo_hospedaje);
        if ($tipoPreferenceValue) {
            $vector[$tipoPreferenceValue] = 1;
        }

        // Map price to budget preferences (Question 3)
        $pricePreferenceValue = $this->mapPriceToPreferencia($hospedaje->precio);
        if ($pricePreferenceValue) {
            $vector[$pricePreferenceValue] = 1;
        }

        return $vector;
    }

    /**
     * Create a user preference vector
     *
     * @param array $userPreferences The user's preference IDs
     * @return array The user preference vector
     */
    public function createUserVector(array $userPreferences): array
    {
        $vector = [];

        // Initialize vector with zeros for all possible preference values
        foreach (PreferenciaEnum::cases() as $preference) {
            $vector[$preference->value] = 0;
        }

        // Set selected preferences to 1
        foreach ($userPreferences as $preferenceId) {
            $vector[$preferenceId] = 1;
        }

        return $vector;
    }

    /**
     * Perform K-means clustering on the hospedaje features
     *
     * @param array $features The hospedaje feature vectors
     * @return array The resulting clusters
     */
    protected function kMeansClustering(array $features): array
    {
        // Initialize clusters with random centroids
        $centroids = $this->initializeCentroids($features);
        $clusters = [];
        $previousAssignments = [];

        // Iterate until convergence or max iterations
        for ($iteration = 0; $iteration < $this->maxIterations; $iteration++) {
            // Assign each hospedaje to the nearest centroid
            $clusters = $this->assignToClusters($features, $centroids);

            // Check for convergence
            $currentAssignments = [];
            foreach ($clusters as $clusterId => $cluster) {
                $currentAssignments[$clusterId] = $cluster['members'];
            }

            if ($this->hasConverged($previousAssignments, $currentAssignments)) {
                break;
            }

            $previousAssignments = $currentAssignments;

            // Update centroids
            $centroids = $this->updateCentroids($features, $clusters);
        }

        return $clusters;
    }

    /**
     * Initialize K random centroids from the feature vectors
     *
     * @param array $features The hospedaje feature vectors
     * @return array The initial centroids
     */
    protected function initializeCentroids(array $features): array
    {
        $centroids = [];
        $featureIndices = array_rand($features, min($this->numClusters, count($features)));

        if (!is_array($featureIndices)) {
            $featureIndices = [$featureIndices];
        }

        foreach ($featureIndices as $index => $featureIndex) {
            $centroids[$index] = $features[$featureIndex];
        }

        return $centroids;
    }

    /**
     * Assign each hospedaje to the nearest centroid
     *
     * @param array $features The hospedaje feature vectors
     * @param array $centroids The cluster centroids
     * @return array The clusters with assigned members
     */
    protected function assignToClusters(array $features, array $centroids): array
    {
        $clusters = [];

        // Initialize empty clusters
        foreach ($centroids as $clusterId => $centroid) {
            $clusters[$clusterId] = [
                'centroid' => $centroid,
                'members' => []
            ];
        }

        // Assign each hospedaje to the nearest centroid
        foreach ($features as $hospedajeIndex => $feature) {
            $minDistance = PHP_FLOAT_MAX;
            $assignedCluster = 0;

            foreach ($centroids as $clusterId => $centroid) {
                $distance = $this->calculateDistance($feature, $centroid);

                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $assignedCluster = $clusterId;
                }
            }

            $clusters[$assignedCluster]['members'][] = $hospedajeIndex;
        }

        return $clusters;
    }

    /**
     * Update centroids based on cluster members
     *
     * @param array $features The hospedaje feature vectors
     * @param array $clusters The current clusters
     * @return array The updated centroids
     */
    protected function updateCentroids(array $features, array $clusters): array
    {
        $centroids = [];

        foreach ($clusters as $clusterId => $cluster) {
            if (empty($cluster['members'])) {
                // If cluster is empty, keep the old centroid
                $centroids[$clusterId] = $cluster['centroid'];
                continue;
            }

            // Calculate the mean of all members in the cluster
            $sum = [];
            foreach ($cluster['members'] as $hospedajeIndex) {
                foreach ($features[$hospedajeIndex] as $key => $value) {
                    if (!isset($sum[$key])) {
                        $sum[$key] = 0;
                    }
                    $sum[$key] += $value;
                }
            }

            $centroid = [];
            $memberCount = count($cluster['members']);
            foreach ($sum as $key => $value) {
                $centroid[$key] = $value / $memberCount;
            }

            $centroids[$clusterId] = $centroid;
        }

        return $centroids;
    }

    /**
     * Check if K-means algorithm has converged
     *
     * @param array $previousAssignments Previous cluster assignments
     * @param array $currentAssignments Current cluster assignments
     * @return bool True if converged, false otherwise
     */
    protected function hasConverged(array $previousAssignments, array $currentAssignments): bool
    {
        if (empty($previousAssignments)) {
            return false;
        }

        foreach ($currentAssignments as $clusterId => $members) {
            // If the cluster size has changed, not converged
            if (!isset($previousAssignments[$clusterId]) ||
                count($members) != count($previousAssignments[$clusterId])) {
                return false;
            }

            // Check if all members are the same
            $diff = array_diff($members, $previousAssignments[$clusterId]);
            if (!empty($diff)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Find the best cluster for a user based on their preference vector
     *
     * @param array $userVector The user preference vector
     * @param array $clusters The K-means clusters
     * @return int The ID of the best cluster
     */
    protected function findBestClusterForUser(array $userVector, array $clusters): int
    {
        $minDistance = PHP_FLOAT_MAX;
        $bestCluster = 0;

        foreach ($clusters as $clusterId => $cluster) {
            $distance = $this->calculateDistance($userVector, $cluster['centroid']);

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $bestCluster = $clusterId;
            }
        }

        return $bestCluster;
    }

    /**
     * Calculate Euclidean distance between two vectors
     *
     * @param array $vector1 First vector
     * @param array $vector2 Second vector
     * @return float The distance
     */
    public function calculateDistance(array $vector1, array $vector2): float
    {
        $sum = 0;

        // Ensure both vectors have the same keys
        $allKeys = array_unique(array_merge(array_keys($vector1), array_keys($vector2)));

        foreach ($allKeys as $key) {
            $v1 = $vector1[$key] ?? 0;
            $v2 = $vector2[$key] ?? 0;
            $sum += pow($v1 - $v2, 2);
        }

        return sqrt($sum);
    }

    /**
     * Map an amenidad description to a preferencia value
     *
     * @param string|int $amenidadId The amenidad ID
     * @return int|null The matching preferencia value or null if no match
     */
    protected function mapAmenidadToPreferencia($amenidadId): ?int
    {
        // Mapeamos las amenidades de AmenidadEnum a las preferencias en PreferenciaEnum
        $mappings = [
            // WiFi mapping to WiFi preference (Pregunta 2, Opción A)
            1 => PreferenciaEnum::PREG_2_OPT_A->value, // WIFI_GRATUITO
            39 => PreferenciaEnum::PREG_2_OPT_A->value, // WIFI_EN_AREAS_COMUNES

            // Pool/Gym mapping to Piscina y gimnasio preference (Pregunta 2, Opción B)
            4 => PreferenciaEnum::PREG_2_OPT_B->value, // PISCINA
            5 => PreferenciaEnum::PREG_2_OPT_B->value, // GIMNASIO
            22 => PreferenciaEnum::PREG_2_OPT_B->value, // JACUZZI
            38 => PreferenciaEnum::PREG_2_OPT_B->value, // ACCESO_A_DEPORTES
            19 => PreferenciaEnum::PREG_2_OPT_B->value, // SPA_O_SERVICIO_DE_MASAJES

            // Restaurant/Bar mapping (Pregunta 2, Opción C)
            8 => PreferenciaEnum::PREG_2_OPT_C->value, // RESTAURANTE_BAR
            40 => PreferenciaEnum::PREG_2_OPT_C->value, // CAFETERIA
            9 => PreferenciaEnum::PREG_2_OPT_C->value, // SERVICIO_DE_HABITACIONES
            30 => PreferenciaEnum::PREG_2_OPT_C->value, // MINIBAR

            // Parking mapping (Pregunta 2, Opción D)
            6 => PreferenciaEnum::PREG_2_OPT_D->value, // ESTACIONAMIENTO
            31 => PreferenciaEnum::PREG_2_OPT_D->value, // ALQUILER_DE_COCHES_O_TRANSPORTE
            21 => PreferenciaEnum::PREG_2_OPT_D->value, // TRASLADO_AL_AEROPUERTO_SHUTTLE

            // Cleaning service mapping (Pregunta 2, Opción E)
            15 => PreferenciaEnum::PREG_2_OPT_E->value, // LIMPIEZA_DIARIA_DE_HABITACION
            17 => PreferenciaEnum::PREG_2_OPT_E->value, // SERVICIO_DE_LAVANDERIA

            // Luxury mappings (Pregunta 1, Opción C)
            16 => PreferenciaEnum::PREG_1_OPT_C->value, // TOALLAS_Y_SABANAS_DE_ALTA_CALIDAD
            28 => PreferenciaEnum::PREG_1_OPT_C->value, // TERRAZA_O_BALCON_PRIVADO
            27 => PreferenciaEnum::PREG_1_OPT_C->value, // CHIMENEA_EN_LA_HABITACION
            36 => PreferenciaEnum::PREG_1_OPT_C->value, // SERVICIOS_DE_CONSERJERIA

            // Family-friendly mappings (Pregunta 1, Opción D)
            34 => PreferenciaEnum::PREG_1_OPT_D->value, // CUNA_O_CAMA_EXTRA_DISPONIBLE_BAJO_SOLICITUD
            26 => PreferenciaEnum::PREG_1_OPT_D->value, // ADMISION_DE_MASCOTAS
            24 => PreferenciaEnum::PREG_1_OPT_D->value, // BARBACOA_O_ZONA_DE_PARRILLAS

            // Modern & minimalist mappings (Pregunta 1, Opción E)
            29 => PreferenciaEnum::PREG_1_OPT_E->value, // SISTEMA_DE_SONIDO
            35 => PreferenciaEnum::PREG_1_OPT_E->value, // ESTACION_DE_CARGA_PARA_DISPOSITIVOS_ELECTRONICOS
            37 => PreferenciaEnum::PREG_1_OPT_E->value, // CINE_O_ZONA_DE_ENTRETENIMIENTO

            // Work & business mappings (Pregunta 1, Opción B - animado y con mucha actividad)
            18 => PreferenciaEnum::PREG_1_OPT_B->value, // CENTRO_DE_NEGOCIOS_ESPACIOS_DE_TRABAJO
            20 => PreferenciaEnum::PREG_1_OPT_B->value, // SALON_DE_EVENTOS_O_SALAS_DE_REUNIONES

            // Tranquil & relaxed mappings (Pregunta 1, Opción A)
            7 => PreferenciaEnum::PREG_1_OPT_A->value, // DESAYUNO_INCLUIDO

            // Sustainability mappings (Pregunta 4, Opciones A y B)
            23 => PreferenciaEnum::PREG_4_OPT_A->value, // BICICLETAS_DISPONIBLES

            // Location and transit mappings (Pregunta 5, Opción A)
            21 => PreferenciaEnum::PREG_5_OPT_A->value, // TRASLADO_AL_AEROPUERTO_SHUTTLE

            // Accessibility mappings
            25 => PreferenciaEnum::PREG_5_OPT_B->value, // ACCESO_PARA_PERSONAS_CON_MOVILIDAD_REDUCIDA
        ];

        // Si es un ID numérico
        if (is_numeric($amenidadId)) {
            return $mappings[(int)$amenidadId] ?? null;
        }

        return null;
    }

    /**
     * Map a hospedaje type to a preferencia value (atmosphere)
     *
     * @param string $tipoDesc The hospedaje type description
     * @return int|null The matching preferencia value or null if no match
     */
    protected function mapTipoHospedajeToPreferencia(string $tipoDesc): ?int
    {
        // Mapeo directo de valores ENUM de tipo_hospedaje a PreferenciaEnum
        $mappings = [
            // Tranquilo y relajado (Pregunta 1, Opción A)
            '5' => PreferenciaEnum::PREG_1_OPT_A->value, // Cabaña
            '10' => PreferenciaEnum::PREG_1_OPT_A->value, // Casa Rural
            '13' => PreferenciaEnum::PREG_1_OPT_A->value, // Bungalow
            '15' => PreferenciaEnum::PREG_1_OPT_A->value, // Glamping
            '9' => PreferenciaEnum::PREG_1_OPT_A->value, // Posada

            // Animado y con mucha actividad (Pregunta 1, Opción B)
            '7' => PreferenciaEnum::PREG_1_OPT_B->value, // Resort
            '2' => PreferenciaEnum::PREG_1_OPT_B->value, // Hostal
            '11' => PreferenciaEnum::PREG_1_OPT_B->value, // Albergue
            '6' => PreferenciaEnum::PREG_1_OPT_B->value, // Camping

            // Lujo y exclusividad (Pregunta 1, Opción C)
            '12' => PreferenciaEnum::PREG_1_OPT_C->value, // Villa
            '14' => PreferenciaEnum::PREG_1_OPT_C->value, // Hacienda

            // Familiar y acogedor (Pregunta 1, Opción D)
            '3' => PreferenciaEnum::PREG_1_OPT_D->value, // Casa de Huéspedes
            '4' => PreferenciaEnum::PREG_1_OPT_D->value, // Apartamento

            // Para hoteles (Pregunta 1, Opción genérica)
            '1' => PreferenciaEnum::PREG_1_OPT_B->value, // Hotel - asumimos animado por defecto
            '8' => PreferenciaEnum::PREG_1_OPT_B->value, // Motel
        ];

        // Si es un valor ENUM directo
        if (isset($mappings[$tipoDesc])) {
            return $mappings[$tipoDesc];
        }

        // Valor predeterminado si no se encuentra una correspondencia
        return PreferenciaEnum::PREG_1_OPT_B->value;
    }

    /**
     * Map a price to a budget preferencia value
     *
     * @param float $price The hospedaje price
     * @return int The matching preferencia value
     */
    protected function mapPriceToPreferencia(float $price): int
    {
        // Define price ranges (these should be adjusted according to your data)
        if ($price < 5000) {
            return PreferenciaEnum::PREG_3_OPT_A->value; // Lo más económico
        } elseif ($price < 10000) {
            return PreferenciaEnum::PREG_3_OPT_B->value; // Buena relación calidad-precio
        } elseif ($price < 15000) {
            return PreferenciaEnum::PREG_3_OPT_D->value; // Dispuesto a pagar un poco más
        } elseif ($price < 20000) {
            return PreferenciaEnum::PREG_3_OPT_E->value; // El precio no importa tanto
        } else {
            return PreferenciaEnum::PREG_3_OPT_C->value; // No importa el precio si la calidad es excelente
        }
    }
}

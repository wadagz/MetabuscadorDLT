<?php

namespace App\Services\RutaTransporte;

use App\Models\Destino;
use App\Models\RutaTransporte;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ItemNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RutaTransporteService
{
    public function obtenerKCaminosMasCortos(int $origin_id, int $target_id, int $K = 3)
    {
        $response = Http::get('http://127.0.0.1:5000/api/kshortestpaths', [
            'origin_id' => $origin_id,
            'target_id' => $target_id,
            'K' => $K,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        logger()->error("External API error", [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        throw new \Exception("External API failed");
    }

    /**
     * Obtiene el id del destino más cercano a unas coordenadas dadas haciendo una llamada
     * al la API del grafo de destinos.
     * @params
     * int $lat
     * int $lon
     * @return id del destino más cercano
     */
    public function obtenerDestinoMasCercanoACoordenadas(float $lat, float $lon)
    {
        $response = Http::get('http://127.0.0.1:5000/api/getNearestDestinoToCoordinates', [
            'lat' => $lat,
            'lon' => $lon,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        logger()->error("External API error", [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        throw new \Exception("Error al obtener destino mas cercano a coordenadas.");
    }

    /**
     * Obtiene las rutas que conforman los caminos más cortos de un destino a otro.
     * @return Array Arreglo con la información de las rutas que conforman los caminos.
     */
    public function obtenerRutasTransporte(int $destinoId, string $puntoPartida)
    {
        [$puntoPartidaId, $infoPuntoPartida] = $this->obtenerPuntoPartidaId($puntoPartida);

        $caminosIds = $this->obtenerKCaminosMasCortos(
            $puntoPartidaId,
            $destinoId,
            5
        )['k_paths'];

        $destinosIds = collect($caminosIds)->flatten()->unique();
        $destinos = Destino::whereIn('id', $destinosIds)->get();

        if ($infoPuntoPartida) {
            $rutaPuntoPartidaAPrimerDestino = [
                'nombreOrigen' => $infoPuntoPartida['nombre'],
                'nombreTarget' => $destinos->find($infoPuntoPartida['id'])->nombre,
                'distancia' => $infoPuntoPartida['distancia'],
                'duracionMin' => $infoPuntoPartida['duracionMin'],
                'precio' => $infoPuntoPartida['precio'],
            ];
        }

        $caminosInfo = collect([]);

        foreach ($caminosIds as $camino) {
            $rutas = collect([]);
            for ($i = 0; $i < count($camino) - 1; $i++) {
                $origenId = $camino[$i];
                $targetId = $camino[$i + 1];
                $rutaModelo = RutaTransporte::where('destino_origen_id', $origenId)
                    ->where('destino_target_id', $targetId)->first();
                $ruta = [
                    'nombreOrigen' => $destinos->find($origenId)->nombre,
                    'nombreTarget' => $destinos->find($targetId)->nombre,
                    'distancia' => $rutaModelo->distancia_km,
                    'duracionMin' => $rutaModelo->duracion_min,
                    'precio' => $rutaModelo->precio,
                ];
                $rutas->push($ruta);
            }

            if ($infoPuntoPartida) {
                $collectionConPuntoPartida = collect([$rutaPuntoPartidaAPrimerDestino]);
                $rutas = $collectionConPuntoPartida->concat($rutas);
            }

            $caminosInfo->push($rutas);
        }

        return $caminosInfo;
    }

    private function obtenerPuntoPartidaId(string $puntoPartida)
    {
        try {
            $puntoPartidaId = Destino::whereLike('nombre', $puntoPartida)->pluck('id')->firstOrFail();
            $infoPuntoPartida = null;
        } catch (ItemNotFoundException $e) {
            $infoPuntoPartida = $this->obtenerDestinoMasCercanoAPuntoPartida($puntoPartida);
            $puntoPartidaId = $infoPuntoPartida['id'];
        }
        return [$puntoPartidaId, $infoPuntoPartida];
    }

    private function obtenerDestinoMasCercanoAPuntoPartida(string $puntoPartida)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'metabuscador-dtl',
            'Accept' => 'application/json',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $puntoPartida . ',Mexico',
            'format' => 'json',
            'limit' => 1,
            'countrycodes' => 'mx',
        ]);

        $data = $response->json();
        if (empty($data)) {
            \Log::debug('obtenerDestinoMasCercanoAPuntoPartida', ['data' => $data]);
            throw new HttpException(500, 'No se pudo trazar rutas del punto de partida al destino.');;
        }

        $lat = $data[0]['lat'];
        $lon = $data[0]['lon'];

        /**
         * Recibe json con:
         * 'id'
         * 'duracionMin'
         * 'distancia'
         * precio
         */
        $infoDestino = $this->obtenerDestinoMasCercanoACoordenadas($lat, $lon);
        $infoDestino['nombre'] = $data[0]['name'];
        return $infoDestino;
    }

}

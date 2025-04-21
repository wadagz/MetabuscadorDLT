<?php

namespace App\Http\Controllers;

use App\Models\Amenidad;
use App\Models\Destino;
use App\Models\Hospedaje;
use App\Models\User;
use App\Services\RecommendationService;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class HospedajeController extends Controller
{
    protected $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function searchHospedaje(Request $request): Response | RedirectResponse
    {
        $rules = [
            'destino' => ['required', Rule::exists('destinos', 'nombre')->where(function (Builder $query) use ($request) {
                $query->whereLike('nombre', $request->input('destino'));
            })],
        ];

        $messages = [
            'destino.required' => 'Ingrese un destino.',
            'destino' => 'No se encontró el destino indicado.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $nombresDestinos = Destino::all()->pluck('nombre')->toArray();
        $destino = Destino::whereLike('nombre', $request->input('destino'))->first();

        $isLoggedIn = Auth::check();
        $hasPreferences = false;
        $compatibilityScores = [];
        $userId = null;
        $amenidades = Amenidad::all();

        // Prepare the hospedajes query with appropriate relationships
        if ($isLoggedIn) {
            $userId = Auth::user()->id;
            $hospedajesQuery = Hospedaje::where('destino_id', $destino->id)->with([
                'direccion',
                'amenidades',
                'usuariosQueDieronFavorito' => function ($query) {
                    $query->where('id', Auth::id());
                }
            ]);
        } else {
            $hospedajesQuery = Hospedaje::where('destino_id', $destino->id)->with('direccion');
        }

        // Get all hospedajes for this destination
        $allHospedajes = $hospedajesQuery->get();

        if ($isLoggedIn) {
            $user = Auth::user();
            $hasPreferences = DB::table('preferencias_usuarios')
                ->where('user_id', $user->id)
                ->exists();

            // If user has preferences, calculate scores and sort hospedajes
            if ($hasPreferences) {
                $userPreferenceIds = DB::table('preferencias_usuarios')
                    ->where('user_id', $user->id)
                    ->join('preferencias', 'preferencias.id', '=', 'preferencias_usuarios.preferencia_id')
                    ->select('preferencias.id')
                    ->pluck('id')
                    ->toArray();

                // Create user preference vector
                $userVector = $this->recommendationService->createUserVector($userPreferenceIds);

                // Calculate compatibility score for each hospedaje
                foreach ($allHospedajes as $hospedaje) {
                    $hospedajeVector = $this->recommendationService->hospedajeToVector($hospedaje, $userPreferenceIds);
                    $distance = $this->recommendationService->calculateDistance($hospedajeVector, $userVector);
                    $maxDistance = sqrt(count($userVector));

                    // Convert distance to a score (0-100), higher is better
                    $compatibilityScores[$hospedaje->id] = round((1 - ($distance / $maxDistance)) * 100);
                }

                // Sort hospedajes by compatibility score (highest first)
                $allHospedajes = $allHospedajes->sortByDesc(function($hospedaje) use ($compatibilityScores) {
                    return $compatibilityScores[$hospedaje->id] ?? 0;
                });
            }
        }

        // Take the first 10 hospedajes from the sorted collection
        $hospedajes = $allHospedajes->take(10)->values();

        return Inertia::render('HospedajesDestino/Index', [
            'destino' => $request->input('destino'),
            'destinoId' => $destino->id,
            'fechaPartida' => $request->input('fechaPartida'),
            'fechaRegreso' => $request->input('fechaRegreso'),
            'puntoPartida' => $request->input('puntoPartida'),
            'hospedajes' => $hospedajes,
            'nombresDestinos' => $nombresDestinos,
            'amenidades' => $amenidades,
            'isLoggedIn' => $isLoggedIn,
            'hasPreferences' => $hasPreferences,
            'compatibilityScores' => $compatibilityScores,
            'userId' => $userId,
        ]);
    }

    public function getHospedajesByDestino($destinoId)
    {
        $hospedajes = Hospedaje::with('direccion')
            ->where('destino_id', $destinoId)
            ->get();

        // Log for debugging
        \Log::info('Hospedajes with direccion count: ' .
                $hospedajes->filter(function($h) {
                    return $h->direccion !== null;
                })->count());

        return response()->json($hospedajes);
    }

    public function show(int $hospedaje_id): Response
    {
        $hospedaje = Hospedaje::where('id', $hospedaje_id)
            ->with([
                'amenidades',
                'direccion',
                'destino',
                'usuariosQueDieronFavorito' => function ($query) {
                    $query->where('id', Auth::id());
                },
            ])
            ->first();

        $isLoggedIn = Auth::check();
        $similarHospedajes = collect([]);
        $compatibilityScores = [];

        if ($isLoggedIn) {
            $user = Auth::user();
            $isAlreadyRecent = $user->vistosReciente->contains($hospedaje);
            if (!$isAlreadyRecent) {
                $user->vistosReciente()->attach($hospedaje);
            }

            // Check if user has preferences
            $hasPreferences = DB::table('preferencias_usuarios')
                ->where('user_id', $user->id)
                ->exists();

            // Get similar hospedajes
            $similarHospedajesQuery = Hospedaje::where('destino_id', $hospedaje->destino_id)
                ->where('id', '!=', $hospedaje->id)
                ->with(['amenidades', 'direccion']);

            // If user has preferences, sort by compatibility
            if ($hasPreferences) {
                $userPreferenceIds = DB::table('preferencias_usuarios')
                    ->where('user_id', $user->id)
                    ->join('preferencias', 'preferencias.id', '=', 'preferencias_usuarios.preferencia_id')
                    ->select('preferencias.id')
                    ->pluck('id')
                    ->toArray();

                $userVector = $this->recommendationService->createUserVector($userPreferenceIds);
                $allSimilarHospedajes = $similarHospedajesQuery->get();

                // Calculate compatibility for each similar hospedaje
                foreach ($allSimilarHospedajes as $similarHospedaje) {
                    $hospedajeVector = $this->recommendationService->hospedajeToVector($similarHospedaje, $userPreferenceIds);
                    $distance = $this->recommendationService->calculateDistance($hospedajeVector, $userVector);
                    $maxDistance = sqrt(count($userVector));
                    $compatibilityScores[$similarHospedaje->id] = round((1 - ($distance / $maxDistance)) * 100);
                }

                // Sort by compatibility and take top 3
                $similarHospedajes = $allSimilarHospedajes->sortByDesc(function($h) use ($compatibilityScores) {
                    return $compatibilityScores[$h->id] ?? 0;
                })->take(3)->values();
            } else {
                // If no preferences, get random similar hospedajes
                $similarHospedajes = $similarHospedajesQuery->inRandomOrder()->limit(3)->get();
            }
        }

        return Inertia::render('Hospedaje/Index', [
            'hospedaje' => $hospedaje,
            'isLoggedIn' => $isLoggedIn,
            'similarHospedajes' => $similarHospedajes,
            'compatibilityScores' => $compatibilityScores,
        ]);
    }

    /**
     * Hace fetch de los hospedajes según los filtros indicados.
     * Método registrado en api.php
     */
    public function filterHospedajes(Request $request)
    {
        \Log::debug('Fetch Hospedajes Query', ['query' => $request->all()]);

        $userId = $request->only('userId');

        if (isset($userId)) {
            $userExists = User::where('id', $userId)->first();
        }
        else {
            $userExists = false;
        }

        $hospedajesQuery = Hospedaje::sort()->filter();

        if ($userExists) {
            $hospedajesQuery = $hospedajesQuery->with([
                'destino',
                'direccion',
                'amenidades',
                'usuariosQueDieronFavorito' => function ($query) {
                    $query->where('id', Auth::id());
                },

            ]);
        }
        else {
            $hospedajesQuery = $hospedajesQuery->with([
                'destino',
                'direccion',
                'amenidades',
            ]);
        }

        $hospedajes = $hospedajesQuery->limit(100)->get();

        return $hospedajes;
    }

    public function getRecommendedHospedajes(Request $request, int $destinoId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $user = Auth::user();
        $limit = $request->input('limit', 5);

        $hasPreferences = DB::table('preferencias_usuarios')
            ->where('user_id', $user->id)
            ->exists();

        if (!$hasPreferences) {
            return response()->json([
                'recommendedHospedajes' => [],
                'hasPreferences' => false,
            ]);
        }

        // Get all hospedajes for compatibility scoring
        $allHospedajes = Hospedaje::where('destino_id', $destinoId)
            ->with(['amenidades', 'direccion'])
            ->get();

        $userPreferenceIds = DB::table('preferencias_usuarios')
            ->where('user_id', $user->id)
            ->join('preferencias', 'preferencias.id', '=', 'preferencias_usuarios.preferencia_id')
            ->select('preferencias.id')
            ->pluck('id')
            ->toArray();

        $userVector = $this->recommendationService->createUserVector($userPreferenceIds);
        $compatibilityScores = [];

        // Calculate compatibility scores
        foreach ($allHospedajes as $hospedaje) {
            $hospedajeVector = $this->recommendationService->hospedajeToVector($hospedaje, $userPreferenceIds);
            $distance = $this->recommendationService->calculateDistance($hospedajeVector, $userVector);
            $maxDistance = sqrt(count($userVector));
            $compatibilityScores[$hospedaje->id] = round((1 - ($distance / $maxDistance)) * 100);
        }

        // Sort by compatibility and take requested number
        $recommendedHospedajes = $allHospedajes->sortByDesc(function($hospedaje) use ($compatibilityScores) {
            return $compatibilityScores[$hospedaje->id] ?? 0;
        })->take($limit)->values();

        return response()->json([
            'recommendedHospedajes' => $recommendedHospedajes,
            'hasPreferences' => true,
            'compatibilityScores' => $compatibilityScores,
        ]);
    }
}

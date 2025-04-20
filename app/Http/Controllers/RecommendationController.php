<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Hospedaje;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RecommendationController extends Controller
{
    protected $recommendationService;

    /**
     * Create a new controller instance.
     *
     * @param RecommendationService $recommendationService
     * @return void
     */
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
        $this->middleware('auth');
    }
    
    /**
     * Get personalized recommendations for the authenticated user in a specific destination
     *
     * @param Request $request
     * @param int $destinoId
     * @return Response
     */
    public function getRecommendations(Request $request, int $destinoId): Response
    {
        $user = Auth::user();
        $destino = Destino::findOrFail($destinoId);
        
        // Comprobar si el usuario tiene preferencias
        $hasPreferences = \DB::table('preferencias_usuarios')
            ->where('user_id', $user->id)
            ->exists();
        
        // Get recommended hospedajes using K-means clustering
        $recommendedHospedajes = $this->recommendationService->getRecommendedHospedajes(
            $user, 
            $destinoId,
            $request->input('limit', 5)
        );
        
        // Get popular hospedajes for comparison (not using K-means)
        $popularHospedajes = Hospedaje::where('destino_id', $destinoId)
            ->with(['amenidades', 'direccion'])
            ->inRandomOrder()
            ->limit(5)
            ->get();
        
        return Inertia::render('Recomendaciones/Index', [
            'destino' => $destino,
            'recommendedHospedajes' => $recommendedHospedajes,
            'popularHospedajes' => $popularHospedajes,
            'hasPreferences' => $hasPreferences,
        ]);
    }
    
    /**
     * Show a comparison of regular hospedajes vs personalized recommendations
     *
     * @param int $destinoId
     * @return Response
     */
    public function compareRecommendations(int $destinoId): Response
    {
        $user = Auth::user();
        $destino = Destino::findOrFail($destinoId);
        
        // Get all hospedajes for the destination
        $allHospedajes = Hospedaje::where('destino_id', $destinoId)
            ->with(['amenidades', 'direccion'])
            ->get();
            
        // Get personalized recommendations
        $recommendedHospedajes = $this->recommendationService->getRecommendedHospedajes(
            $user, 
            $destinoId,
            5
        );
        
        // Obtener las preferencias del usuario con una consulta específica
        $userPreferences = \DB::table('preferencias_usuarios')
            ->where('user_id', $user->id)
            ->join('preferencias', 'preferencias.id', '=', 'preferencias_usuarios.preferencia_id')
            ->select('preferencias.*')
            ->get();
        
        // Calculate user's preference compatibility with each hospedaje
        $compatibilityScores = [];
        foreach ($allHospedajes as $hospedaje) {
            $userPreferenceIds = $userPreferences->pluck('id')->toArray();
            $hospedajeVector = $this->recommendationService->hospedajeToVector($hospedaje, []);
            $userVector = $this->recommendationService->createUserVector($userPreferenceIds);
            
            // Lower distance means higher compatibility
            $distance = $this->recommendationService->calculateDistance($hospedajeVector, $userVector);
            $maxDistance = sqrt(count($userVector)); // Maximum possible distance (all 1's vs all 0's)
            
            // Convert distance to a score between 0 and 100
            $compatibilityScores[$hospedaje->id] = round((1 - ($distance / $maxDistance)) * 100);
        }
        
        return Inertia::render('Recomendaciones/Comparacion', [
            'destino' => $destino,
            'allHospedajes' => $allHospedajes,
            'recommendedHospedajes' => $recommendedHospedajes,
            'compatibilityScores' => $compatibilityScores,
            'userPreferences' => $userPreferences,
        ]);
    }
}
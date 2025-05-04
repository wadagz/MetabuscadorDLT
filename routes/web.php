<?php

use App\Http\Controllers\{DestinoController, ActividadController};
use App\Http\Controllers\{FavoritosHospedajeUsuarioController, HospedajeController, LandingPageController, PlanViajeController, RecommendationController, ResenaHospedajeController, UserController, VistosRecienteController};
use Illuminate\Support\Facades\Route;

Route::get('/landing', [LandingPageController::class, 'index']);

Route::get('/', [DestinoController::class, 'index'])->name('landing');

Route::get('/hospedajes', [HospedajeController::class, 'searchHospedaje'])->name('searchHospedaje');
Route::get('/hospedajes/{hospedaje_id}', [HospedajeController::class, 'show'])->name('hospedaje.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/preferences', function () {
        return view('user-preferences');
    })->name('user-preferences');
    Route::get('/customer-help', function () {
        return view('customer-help');
    })->name('customer-help');

    Route::post('/preferences', [UserController::class, 'storePreferences'])->name('user-preferences.store');

    Route::get('/favoritos', [UserController::class, 'showFavorites'])->name('user-favorites.index');
    Route::post('/favoritos/{hospedaje_id}', [FavoritosHospedajeUsuarioController::class, 'addToFavorites'])->name('add-hospedaje-to-favorites');
    Route::delete('/favoritos/{hospedaje_id}', [FavoritosHospedajeUsuarioController::class, 'removeFromFavorites'])->name('remove-hospedaje-from-favorites');
    Route::get('/favoritos/{destino_id}', [UserController::class, 'showFavoritesInDestination'])->name('user-favorites-in-destination');

    Route::get('/vistosReciente', [VistosRecienteController::class, 'recentlyViewed'])->name('recentlyViewed.index');

    Route::post('/resenaHospedaje/{hospedaje_id}', [ResenaHospedajeController::class, 'addReview'])->name('reviewHospedaje.add');
    Route::patch('/resenaHospedaje/{hospedaje_id}', [ResenaHospedajeController::class, 'update'])->name('reviewHospedaje.update');
    Route::delete('/resenaHospedaje/{resena_id}', [ResenaHospedajeController::class, 'delete'])->name('reviewHospedaje.destroy');

    // Rutas para el sistema de recomendación
    Route::get('/destinos/{destino}/recomendaciones', [RecommendationController::class, 'getRecommendations'])
        ->name('destinos.recomendaciones');
    Route::get('/destinos/{destino}/comparar-recomendaciones', [RecommendationController::class, 'compareRecommendations'])
        ->name('destinos.comparar-recomendaciones');

    Route::get('planViaje', [PlanViajeController::class, 'index'])->name('planViaje.index');
    Route::get('/planviaje/{planViajeId}', [PlanViajeController::class, 'show'])->name('planViaje.show');
    Route::get('/planviaje/crear/{hospedajeId}', [PlanViajeController::class, 'create'])->name('planViaje.create');
    Route::post('/planviaje', [PlanViajeController::class, 'store'])->name('planViaje.store');
    Route::post('/planviaje/updateParams', [PlanViajeController::class, 'updateParameters'])->name('planViaje.updateParameters');
    Route::delete('planViaje/{planViajeId}', [PlanViajeController::class, 'destroy'])->name('planViaje.destroy');

    Route::get('/actividad/{actividadId}', [ActividadController::class, 'show'])->name('actividad.show');
});

// Ruta API para obtener hospedajes por destino (utilizada por el mapa)
Route::get('/api/destinos/{destinoId}/hospedajes', [HospedajeController::class, 'getHospedajesByDestino']);

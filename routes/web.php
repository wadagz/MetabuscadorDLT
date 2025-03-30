<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\{FavoritosHospedajeUsuarioController, HospedajeController, LandingPageController, UserController};
use Illuminate\Support\Facades\Route;

Route::get('/landing', [LandingPageController::class, 'index']);

Route::get('/', [DestinoController::class, 'index'])->name('landing');

Route::get('/hospedajes', [HospedajeController::class, 'searchHospedaje'])->name('searchHospedaje');

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
    Route::post('/favoritos/{hospedaje_id}', [FavoritosHospedajeUsuarioController::class, 'addToFavorites'])->name('add-hospedaje-to-favorites');
    Route::delete('/favoritos/{hospedaje_id}', [FavoritosHospedajeUsuarioController::class, 'removeFromFavorites'])->name('remove-hospedaje-from-favorites');
});

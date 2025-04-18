<?php

use App\Http\Controllers\DireccionController;
use App\Http\Controllers\HospedajeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Direcciones API routes
Route::prefix('direcciones')->name('direcciones.')->group(function () {
    // Basic CRUD operations
    Route::get('/', [DireccionController::class, 'index'])->name('index');
    Route::post('/', [DireccionController::class, 'store'])->name('store');
    Route::get('/{id}', [DireccionController::class, 'show'])->name('show');
    Route::put('/{id}', [DireccionController::class, 'update'])->name('update');
    Route::delete('/{id}', [DireccionController::class, 'destroy'])->name('destroy');

    // Map-related functionality
    Route::get('/destino/{destinoId}', [DireccionController::class, 'getDireccionesByDestino'])->name('by-destino');
    Route::get('/hospedaje/{hospedajeId}', [DireccionController::class, 'getDireccionByHospedaje'])->name('by-hospedaje');
    Route::patch('/{id}/coordinates', [DireccionController::class, 'updateCoordinates'])->name('update-coordinates');
});

Route::get('/hospedajes', [HospedajeController::class, 'fetchHospedajes'])->name('hospedajes');

// If you want to secure these routes, wrap them in auth middleware like:
/*
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('direcciones')->name('direcciones.')->group(function () {
        // All the routes above
    });
});
*/

<?php

use Illuminate\Support\Facades\Route;
use Inertia\{ Inertia, Response };

Route::get('/', function () {
    return Inertia::render('Landing');
})->name('landing');


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
});

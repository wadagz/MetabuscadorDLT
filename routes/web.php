<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


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
    Route::delete('user/delete', function () {
            $user = Auth::user();
            $user->delete();
            return redirect()->route('welcome');
    })->name('deleteUser');
});

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavoritosHospedajeUsuarioController extends Controller
{
    /**
     * Relaciona el hospedaje y el usuario a través de la tabla favoritos_hospedaje_usuario.
     */
    public function addToFavorites(Request $request, int $hospedaje_id)
    {
        $rules = [
            'hospedaje_id' => ['required', 'exists:hospedajes,id'],
        ];

        $messages = [
            'hospedaje_id.required' => 'Es necesario un identificador de hospedaje.',
            'hospedaje_id.exists' => 'No existe el hospedaje.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $user = Auth::user();
        $user->hospedajesFavoritos()->attach($hospedaje_id);
    }

    /**
     * Elimina la relación entre el hospedaje y el usuario a través de la tabla favoritos_hospedaje_usuario.
     */
    public function removeFromFavorites(Request $request, int $hospedaje_id)
    {
        $user = Auth::user();

        $rules = [
            'hospedaje_id' => [
                'required',
                'exists:hospedajes,id',
                function ($attribute, $value, $fail) use ($user) { // Comprueba que sí exista una relación entre el usuario y el hospedaje.
                    $hospedaje = $user->hospedajesFavoritos()->where('hospedajes.id', $value)->exists();
                    if (!$hospedaje) {
                        $fail('No tienes este hospedaje en tu lista de favoritos.');
                    }
                }
            ],
        ];

        $messages = [
            'hospedaje_id' => 'Ocurrió un problema.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $user->hospedajesFavoritos()->detach($hospedaje_id);
    }
}

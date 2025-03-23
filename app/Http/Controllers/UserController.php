<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function storePreferences(Request $request)
    {
        // Asocia los id de las preferencias de la tabla Preferencias
        // con el usuario en la tabla preferencias_usuarios.
        // El método sync elimina los registros del usuario cuyos preferencia_id
        // no se encuentre listado en el arreglo devuelto por $request->except.
        $user = $request->user();
        $user->preferencias()->sync($request->except(['_token']));
        return redirect()->route('user-preferences')->with(['message' => 'Preferencias actualizadas.']);
    }
}

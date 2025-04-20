<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\{Inertia, Response};

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
        return redirect()->route('user-preferences')->with('success', 'Preferencias actualizadas correctamente.');
    }

    public function showFavorites(): Response
    {
        // Obtener los hospedajes favoritos agrupados por el nombre del destino.
        $favoritos = Auth::user()->hospedajesFavoritos->groupBy('destino_id');
        $destinos = Destino::whereIn('id', $favoritos->keys())->pluck('nombre', 'id');
        // $favoritosWithNames = $favoritos->mapWithKeys(function ($items, $destinoId) use ($destinos) {
        //     return [$destinos[$destinoId] => $items];  // Replace destino_id with the name
        // });

        return Inertia::render('Profile/Favoritos', [
            'favoritos' => $favoritos->isEmpty() ? null : $favoritos,
            'destinos' => $destinos,
        ]);
    }

    public function showFavoritesInDestination(int $destino_id)
    {
        $hospedajes = Auth::user()->hospedajesFavoritos->where('destino_id', $destino_id);

        return Inertia::render('Profile/FavoritesInDestination', [
            'hospedajes' => $hospedajes,
            'destino' => Destino::find($destino_id),
        ]);
    }
}

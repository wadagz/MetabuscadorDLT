<?php

namespace App\Http\Controllers;

use App\Models\Amenidad;
use App\Models\Destino;
use App\Models\Hospedaje;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class HospedajeController extends Controller
{

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

        // Si el usuario está logeado obtiene los hospedajes con los usuarios que dieron favorito.
        // para de esta forma mostrar en el frontend los hospedajes favoritos del usuario.
        if ($isLoggedIn) {
            $userId = Auth::user()->id;
            $hospedajesQuery = Hospedaje::where('destino_id', $destino->id)->with(['direccion', 'usuariosQueDieronFavorito' => function ($query) {
                $query->where('id', Auth::id());
            }]);
        }
        else {
            $userId = null;
            $hospedajesQuery = Hospedaje::where('destino_id', $destino->id)->with('direccion');
        }

        $hospedajes = $hospedajesQuery->limit(10)->get();
        $amenidades = Amenidad::all();

        return Inertia::render('HospedajesDestino/Index', [
            'destino' => $request->input('destino'),
            'fechaPartida' => $request->input('fechaPartida'),
            'fechaRegreso' => $request->input('fechaRegreso'),
            'puntoPartida' => $request->input('puntoPartida'),
            'hospedajes' => $hospedajes,
            'nombresDestinos' => $nombresDestinos,
            'amenidades' => $amenidades,
            'isLoggedIn' => $isLoggedIn,
            'destinoId' => $destino->id,
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

        if ($isLoggedIn) {
            $user = Auth::user();
            $isAlreadyRecent = $user->vistosReciente->contains($hospedaje);
            if (!$isAlreadyRecent) {
                $user->vistosReciente()->attach($hospedaje);
            }
        }

        return Inertia::render('Hospedaje/Index', [
            'hospedaje' => $hospedaje,
            'isLoggedIn' => Auth::check(),
        ]);
    }

    /**
     * Hace fetch de los hospedajes según los filtros indicados.
     * Método registrado en api.php
     */
    public function fetchHospedajes(Request $request)
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
}

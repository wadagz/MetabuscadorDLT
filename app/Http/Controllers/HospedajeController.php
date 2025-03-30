<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Hospedaje;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class HospedajeController extends Controller
{

    public function searchHospedaje(Request $request): Response | RedirectResponse
    {
        $messages = [
            'destino.required' => 'Ingrese un destino.',
            'destino' => 'No se encontró el destino indicado.',
        ];

        Validator::make($request->all(), [
            'destino' => ['required', Rule::exists('destinos', 'nombre')->where(function ($query) use ($request) {
                $query->whereLike('nombre', $request->input('destino'));
            })],
        ], $messages)->validate();

        $nombresDestinos = Destino::all()->pluck('nombre')->toArray();
        $destino = Destino::whereLike('nombre', $request->input('destino'))->first();
        $hospedajes = Hospedaje::where('destino_id', $destino->id)->get();

        return Inertia::render('HospedajesDestino/Index', [
            'destino' => $request->input('destino'),
            'fechaPartida' => $request->input('fechaPartida'),
            'fechaRegreso' => $request->input('fechaRegreso'),
            'puntoPartida' => $request->input('puntoPartida'),
            'hospedajes' => $hospedajes,
            'nombresDestinos' => $nombresDestinos,
        ]);
    }
}

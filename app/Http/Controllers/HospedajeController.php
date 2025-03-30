<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Hospedaje;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HospedajeController extends Controller
{
    public function searchHospedaje(Request $request): Response
    {
        $destino = Destino::whereLike('nombre', $request->query()['destino'])->first();
        $hospedajes = Hospedaje::where('destino_id', $destino->id)->get();
        // dd($hospedajes);


        return Inertia::render('HospedajesDestino/Index', [
            'destino' => $request->query()['destino'],
            'fechaPartida' => $request->query()['fechaPartida'],
            'fechaRegreso' => $request->query()['fechaRegreso'],
            'puntoPartida' => $request->query()['puntoPartida'],
            'hospedajes' => $hospedajes,
        ]);
    }
}

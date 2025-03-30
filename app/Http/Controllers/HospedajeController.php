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
        $destino = Destino::whereLike('nombre', $request->input('destino'))->first();
        $hospedajes = Hospedaje::where('destino_id', $destino->id)->get();

        return Inertia::render('HospedajesDestino/Index', [
            'destino' => $request->input('destino'),
            'fechaPartida' => $request->input('fechaPartida'),
            'fechaRegreso' => $request->input('fechaRegreso'),
            'puntoPartida' => $request->input('puntoPartida'),
            'hospedajes' => $hospedajes,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HospedajeController extends Controller
{
    public function searchHospedaje(Request $request): Response
    {
        return Inertia::render('HospedajesDestino/Index', [
            'destino' => $request->query()['destino'],
            'fechaPartida' => $request->query()['fechaPartida'],
            'fechaRegreso' => $request->query()['fechaRegreso'],
            'puntoPartida' => $request->query()['puntoPartida'],
        ]);
    }
}

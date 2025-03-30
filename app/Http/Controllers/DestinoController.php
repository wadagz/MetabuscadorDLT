<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;
use Inertia\{ Inertia, Response };

class DestinoController extends Controller
{
    public function index(): Response
    {
        $destinosPopulares = Destino::inRandomOrder()->limit(10)->get();
        $destinosRecomendados = Destino::inRandomOrder()->limit(10)->get();
        $nombresDestinos = Destino::all()->pluck('nombre')->toArray();
        return Inertia::render('Landing', [
            'destinosPopulares' => $destinosPopulares,
            'destinosRecomendados' => $destinosRecomendados,
            'nombresDestinos' => $nombresDestinos,
        ]);
    }
}

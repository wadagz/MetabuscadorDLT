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

        $planViajeCookie = request()->cookie('plan_viaje');
        $destino = null;
        $fechaPartida = null;
        $fechaRegreso = null;
        $puntoPartida = null;

        if (isset($planViajeCookie)) {
            $planViajeParams = json_decode($planViajeCookie);
            $destino = $planViajeParams->destinoNombre;
            $fechaPartida = $planViajeParams->fechaPartida;
            $fechaRegreso = $planViajeParams->fechaRegreso;
            $puntoPartida = $planViajeParams->puntoPartida;
        }

        return Inertia::render('Landing', [
            'destinosPopulares' => $destinosPopulares,
            'destinosRecomendados' => $destinosRecomendados,
            'nombresDestinos' => $nombresDestinos,
            'destino' => $destino,
            'fechaPartida' => $fechaPartida,
            'fechaRegreso' => $fechaRegreso,
            'puntoPartida'=> $puntoPartida,
        ]);
    }
}

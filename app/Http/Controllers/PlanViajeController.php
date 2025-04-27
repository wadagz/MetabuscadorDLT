<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Services\RutaTransporte\RutaTransporteService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlanViajeController extends Controller
{
    private function rutasTransporte(
        RutaTransporteService $rutasService,
        int $origin_id,
        int $target_id,
        int $K = 3
    )
    {
        $rutas = $rutasService->obtenerKCaminosMasCortos(
            $origin_id,
            $target_id,
            $K
        );

        dd($rutas);
    }

    public function create(): Response
    {
        $planViajeCookie = request()->cookie('plan_viaje');
        $destino = null;
        $fechaPartida = null;
        $fechaRegreso = null;
        $puntoPartida = null;

        if (isset($planViajeCookie)) {
            $planViajeParams = json_decode($planViajeCookie);
            $destino = Destino::where('id', $planViajeParams->destinoId)->first();
            $fechaPartida = intval($planViajeParams->fechaPartida);
            $fechaRegreso = intval($planViajeParams->fechaRegreso);
            // Obtener el destino más cercano a la ubicacion dada
            // haciendo uso de nominatim.
            $puntoPartida = $planViajeParams->puntoPartida;

            // $destino = Destino::
        }

        // $rutas = $this->rutasTransporte()

        return Inertia::render('PlanViaje/Index', [
            'destino' => $destino,
            'fechaPartida' => $fechaPartida,
            'fechaRegreso' => $fechaRegreso,
            'puntoPartida'=> $puntoPartida,
        ]);
    }
}

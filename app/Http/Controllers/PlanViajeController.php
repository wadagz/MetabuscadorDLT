<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Services\RutaTransporte\RutaTransporteService;
use Inertia\Inertia;
use Inertia\Response;

class PlanViajeController extends Controller
{
    protected $rutaTransporteService;

    public function __construct(RutaTransporteService $rutaTransporteService)
    {
        $this->rutaTransporteService = $rutaTransporteService;
    }

    public function showRoutes(): Response
    {
        $planViajeCookie = request()->cookie('plan_viaje');
        $destino = null;
        $fechaPartida = null;
        $fechaRegreso = null;
        $puntoPartida = null;
        $caminos = null;

        if (isset($planViajeCookie)) {
            $planViajeParams = json_decode($planViajeCookie);
            $destinoId = $planViajeParams->destinoId;
            $destino = Destino::where('id', $planViajeParams->destinoId)->first();
            $fechaPartida = $planViajeParams->fechaPartida;
            $fechaRegreso = $planViajeParams->fechaRegreso;
            $puntoPartida = $planViajeParams->puntoPartida;

            $caminos = $this->rutaTransporteService->obtenerRutasTransporte($destinoId, $puntoPartida);
        }

        return Inertia::render('PlanViaje/Index', [
            'destino' => $destino,
            'fechaPartida' => $fechaPartida,
            'fechaRegreso' => $fechaRegreso,
            'puntoPartida'=> $puntoPartida,
            'caminos' => $caminos,
        ]);
    }

    public function updateParameters(Request $request)
    {
        $planViajeCookie = request()->cookie('plan_viaje');
        $planViajeParams = json_decode($planViajeCookie);

        Cookie::queue('plan_viaje', json_encode([
            'destinoId' => $planViajeParams->destinoId,
            'destinoNombre' => $planViajeParams->destinoNombre,
            'fechaPartida' => $request->input('fechaPartida'),
            'fechaRegreso' => $request->input('fechaRegreso'),
            'puntoPartida' => $request->input('puntoPartida'),
            'viajeRedondo' => $request->input('viajeRedondo'),
        ]
        ), 1440);

        return redirect()->route('planViaje.create', [
            'hospedajeId' => $request->input('hospedajeId'),
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Hospedaje;
use App\Services\RutaTransporte\RutaTransporteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PlanViajeController extends Controller
{
    protected $rutaTransporteService;

    public function __construct(RutaTransporteService $rutaTransporteService)
    {
        $this->rutaTransporteService = $rutaTransporteService;
    }

    public function create(int $hospedajeId): Response | RedirectResponse
    {
        $planViajeCookie = request()->cookie('plan_viaje');

        if (!isset($planViajeCookie)) {
            return redirect()->back();
        }

        $destino = null;
        $fechaPartida = null;
        $fechaRegreso = null;
        $puntoPartida = null;
        $caminos = null;

        $planViajeParams = json_decode($planViajeCookie);
        $destinoId = $planViajeParams->destinoId;
        $destino = Destino::where('id', $planViajeParams->destinoId)->first();
        $fechaPartida = $planViajeParams->fechaPartida;
        $fechaRegreso = $planViajeParams->fechaRegreso;
        $puntoPartida = $planViajeParams->puntoPartida;
        $viajeRedondo = $planViajeParams->viajeRedondo;

        $caminos = $this->rutaTransporteService->obtenerRutasTransporte($puntoPartida, $destinoId);

        $hospedaje = Hospedaje::where('id', $hospedajeId)->with(['direccion'])->first();

        return Inertia::render('PlanViaje/Index', [
            'destino' => $destino,
            'fechaPartida' => $fechaPartida,
            'fechaRegreso' => $fechaRegreso,
            'puntoPartida'=> $puntoPartida,
            'viajeRedondo' => $viajeRedondo,
            'caminos' => $caminos,
            'hospedaje' => $hospedaje,
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

    public function store(Request $request)
    {
        dd($request);
        //crear plan de viaje
        //crear itenerario para cada ruta
        //redirigir a vista donde se muestre la confirmación del viaje.
        //en esta pagina mostrar actividades sugeridas.
    }
}

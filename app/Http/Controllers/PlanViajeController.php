<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Destino;
use App\Models\Hospedaje;
use App\Models\Itinerario;
use App\Models\PlanViaje;
use App\Services\RutaTransporte\RutaTransporteService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function index(): Response
    {
        $user = Auth::user();
        $planesViaje = PlanViaje::where('user_id', $user->id)
            ->with(['hospedaje'])
            ->get();
        return Inertia::render('PlanViaje/Index', [
            'planesViaje' => $planesViaje,
        ]);
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

        $caminos = $this->rutaTransporteService->obtenerRutasTransporte($puntoPartida, $destinoId, 10);

        $hospedaje = Hospedaje::where('id', $hospedajeId)->with(['direccion'])->first();

        return Inertia::render('PlanViaje/Create', [
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

    public function show(int $planViajeId): Response
    {
        $planViaje = PlanViaje::where('id', $planViajeId)
            ->with(['itinerarios.rutaTransporte', 'hospedaje.direccion'])
            ->first();

        $actividadesEventuales = Actividad::where('destino_id', $planViaje->hospedaje->destino_id)
            ->where('tipo', 'eventual')
            ->with(['direccion'])
            ->get();

        $actividadesRecurrentes = Actividad::where('destino_id', $planViaje->hospedaje->destino_id)
            ->where('tipo', 'recurrente')
            ->with(['direccion'])
            ->get();

        return Inertia::render('PlanViaje/Show', [
            'planViaje' => $planViaje,
            'actividadesEventuales' => $actividadesEventuales,
            'actividadesRecurrentes' => $actividadesRecurrentes,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate(
            [
                'destinoId' => 'required|integer|exists:destinos,id',
                'hospedajeId' => 'required|integer|exists:hospedajes,id',
                'fechaPartida' => 'required|date|after:today',
                'fechaRegreso' => 'required|date|after:fechaPartida',
                'puntoPartida' => 'required|string',
                'viajeRedondo' => 'required|boolean',
                'caminoSeleccionado' => 'required',
                'precioTotal' => 'required|numeric',
                'tiempoTotal' => 'required|numeric',
            ]
        );
        // dd($validated);

        //crear plan de viaje
        $fechaComienzo = new DateTime($validated['fechaPartida']);
        $fechaFin = new DateTime($validated['fechaRegreso']);
        // dd($validated['puntoPartida']);

        $planViaje = PlanViaje::create([
            'user_id' => $user->id,
            'hospedaje_id' => $validated['hospedajeId'],
            'punto_partida' => $validated['puntoPartida'],
            'destino' => Destino::where('id', $validated['destinoId'])->pluck('nombre')->first(),
            'fecha_comienzo' => $fechaComienzo->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'precio' => $validated['precioTotal'],
            'viaje_redondo' => $validated['viajeRedondo'],
        ]);
        //crear itenerario para cada ruta
        $orden = 0;
        foreach ($validated['caminoSeleccionado'] as $ruta) {
            Itinerario::create([
                'plan_viaje_id' => $planViaje->id,
                'ruta_transporte_id' => $ruta['id'],
                'orden' => $orden,
                'tipo' => 'ida',
            ]);
            $orden++;
        }

        if ($validated['viajeRedondo']) {
            $reversedCamino = array_reverse($validated['caminoSeleccionado']);
            foreach ($reversedCamino as $rutaRegreso) {
                Itinerario::create([
                    'plan_viaje_id' => $planViaje->id,
                    'ruta_transporte_id' => $rutaRegreso['id'],
                    'orden' => $orden,
                    'tipo' => 'regreso',
                ]);
                $orden++;
            }
        }
        //redirigir a vista donde se muestre la confirmación del viaje.
        //en esta pagina mostrar actividades sugeridas.
        return redirect()->route('planViaje.show', [
            'planViajeId' => $planViaje->id,
        ]);
    }

    public function destroy(int $planViajeId)
    {
        $planViaje = PlanViaje::where('id', $planViajeId);
        $planViaje->delete();
        return redirect()->route('planViaje.index');
    }
}

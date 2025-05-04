<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActividadController extends Controller
{
    public function show(int $actividadId)
    {
        $actividad = Actividad::where('id', $actividadId)
            ->with(['destino', 'direccion'])
            ->first();

        if ($actividad->tipo == 'recurrente') {
            $actividad->load(['horariosRecurrentes']);
        }
        else {
            $actividad->load(['horariosEventuales']);
        }

        return Inertia::render('Actividad/Show', [
            'actividad' => $actividad,
        ]);
    }
}

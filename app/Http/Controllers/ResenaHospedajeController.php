<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Hospedaje;
use App\Models\ResenaHospedaje;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;


class ResenaHospedajeController extends Controller
{
    /**
     * Agrega una reseña escritor por un usuario de un hospedaje.
     */
    public function addReview(Request $request, int $hospedaje_id)
    {
        $rules = [
            'comentario' => ['required', 'string'],
            'calificacion' => ['required', 'numeric', 'between:1,5'],
        ];

        $messages = [
            'comentario' => 'Es necesario un comentario.',
            'calificacion' => 'Es necesaria una calificación entre 1 y 5 estrellas.',
        ];

        $validated = Validator::make($request->all(), $rules, $messages)->validate();

        $user = Auth::user();

        $fecha = Carbon::now();

        ResenaHospedaje::create([
            'comentario' => $validated['comentario'],
            'calificacion' => $validated['calificacion'],
            'fecha' => $fecha->toDateString(),
            'user_id' => $user->id,
            'hospedaje_id' => $hospedaje_id,
        ]);
    }

    public function update(Request $request, int $hospedaje_id)
    {
        $rules = [
            'comentario' => ['required', 'string'],
            'calificacion' => ['required', 'numeric', 'between:1,5'],
        ];

        $messages = [
            'comentario' => 'Es necesario un comentario.',
            'calificacion' => 'Es necesaria una calificación entre 1 y 5 estrellas.',
        ];

        $validated = Validator::make($request->all(), $rules, $messages)->validate();

        $user = Auth::user();

        $fecha = Carbon::now();

        $user->resenasHopedajes()->updateExistingPivot($hospedaje_id, [
            'comentario' => $validated['comentario'],
            'calificacion' => $validated['calificacion'],
            'fecha' => $fecha->toDateString(),
        ]);
    }

    public function delete(int $resena_id)
    {
        $resenaHospedaje = ResenaHospedaje::where('id', $resena_id)->firstOrFail();
        $resenaHospedaje->delete();
    }
}

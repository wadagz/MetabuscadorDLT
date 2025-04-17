<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Hospedaje;
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
    public function addReview(Request $request, int $hospedaje_id): void
    {
        $rules = [
            'comentario' => ['required', 'string'],
            'calificacion' => ['required', 'numeric', 'between:1,5'],
        ];

        $messages = [
            'comentario' => 'Es necesario un comentario.',
            'calificacion' => 'Es necesaria una calificación entre 1 y 5.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $user = Auth::user();
        // Crear modelo intermedio
        // Hacer el attach a user y hospedaje
    }
}

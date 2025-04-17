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


class VistosRecienteController extends Controller
{
    public function recentlyViewed(): Response
    {
        $user = Auth::user();
        $vistosReciente = $user->vistosReciente()
            ->orderByPivot('created_at', 'desc')
            ->limit(10)
            ->get();
        return Inertia::render('VistosReciente/Index', [
            'vistosReciente' => $vistosReciente->isEmpty() ? null : $vistosReciente,
        ]);
    }
}

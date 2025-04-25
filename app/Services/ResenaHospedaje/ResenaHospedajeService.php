<?php

namespace App\Services\ResenaHospedaje;

use App\Models\Hospedaje;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ResenaHospedajeService
{
    public function calculateCalPromForEveryHospedaje(): void
    {
        Hospedaje::withCount([
            'resenasDeUsuarios as avg_score' => function ($query) {
                $query->select(DB::raw('avg(calificacion)'));
            },
        ])->chunk(500, function (Collection $hospedajes) {
                foreach ($hospedajes as $hospedaje) {
                    $integerPart = floor($hospedaje->avg_score);
                    $decimalPart = $hospedaje->avg_score - $integerPart;
                    if ($integerPart == 4 and $decimalPart >= 0.1) {
                        $avg_score = ceil($hospedaje->avg_score);
                    } else if ($decimalPart >= 5) {
                        $avg_score = ceil($hospedaje->avg_score);
                    } else {
                        $avg_score = floor($hospedaje->avg_score);
                    }
                    $hospedaje->cal_prom = $avg_score;
                    $hospedaje->save();
                }
            });
    }
}

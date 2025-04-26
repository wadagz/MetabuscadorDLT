<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Itinerario extends Model
{
    protected $table = 'itinerarios';

    protected $fillable = [
        'plan_viaje_id',
        'ruta_transporte_id',
        'orden',
        'tipo'
    ];

    public function planViaje(): BelongsTo
    {
        return $this->belongsTo(PlanViaje::class);
    }

    public function rutaTransporte(): BelongsTo
    {
        return $this->belongsTo(RutaTransporte::class);
    }
}

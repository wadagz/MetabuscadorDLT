<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RutaTransporte extends Model
{
    protected $table = 'rutas_transporte';

    protected $fillable = [
            'empresa_transporte_id',
            'destino_origen_id',
            'destino_target_id',
            'tipo',
            'distancia_km',
            'duracion_min',
            'precio',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresaTransporte::class, 'empresa_transporte_id');
    }
}

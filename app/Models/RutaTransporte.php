<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
            'destino_origen_nombre',
            'destino_target_nombre',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresaTransporte::class, 'empresa_transporte_id');
    }

    public function resenasDeUsuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'resenas_transporte',
            'ruta_transporte_id',
            'user_id'
        )->withPivot(
            [
                'calificacion',
                'comentario',
                'created_at',
                'updated_at'
            ]
        );
    }
}

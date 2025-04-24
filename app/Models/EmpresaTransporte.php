<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmpresaTransporte extends Model
{
    protected $table = 'empresas_transporte';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
    ];

    public function rutas(): HasMany
    {
        return $this->hasMany(RutaTransporte::class, 'empresa_transporte_id');
    }
}

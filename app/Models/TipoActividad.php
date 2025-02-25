<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoActividad extends Model
{
    /** @use HasFactory<\Database\Factories\TipoActividadFactory> */
    use HasFactory;

    protected $table = 'tipos_actividad';
}

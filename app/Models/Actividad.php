<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    /** @use HasFactory<\Database\Factories\ActividadFactory> */
    use HasFactory;

    protected $table = 'actividades';
}

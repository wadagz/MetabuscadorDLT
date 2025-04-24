<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ResenaTransporte extends Model
{
    use HasFactory;

    protected $table = 'resenas_transporte';

    protected $fillable = [
        'user_id',
        'ruta_transporte_id',
        'calificacion',
        'comentario',
    ];
}

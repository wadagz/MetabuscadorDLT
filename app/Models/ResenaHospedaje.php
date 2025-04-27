<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResenaHospedaje extends Model
{
    /** @use HasFactory<\Database\Factories\ResenaHospedajeFactory> */
    use HasFactory;

    protected $table = 'resenas_hospedaje';

    protected $fillable = [
        'comentario',
        'calificacion',
        'user_id',
        'hospedaje_id',
        'fecha',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hospedaje(): BelongsTo
    {
        return $this->belongsTo(Hospedaje::class, 'hospedaje_id');
    }
}

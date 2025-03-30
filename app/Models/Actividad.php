<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actividad extends Model
{
    /** @use HasFactory<\Database\Factories\ActividadFactory> */
    use HasFactory;

    protected $table = 'actividades';

    public function destino(): BelongsTo
    {
        return $this->belongsTo(Destino::class);
    }
}

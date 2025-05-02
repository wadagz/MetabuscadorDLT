<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actividad extends Model
{
    /** @use HasFactory<\Database\Factories\ActividadFactory> */
    use HasFactory;

    protected $table = 'actividades';

    public function destino(): BelongsTo
    {
        return $this->belongsTo(Destino::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class);
    }

    public function horariosRecurrentes(): HasMany
    {
        return $this->hasMany(HorarioRecurrente::class);
    }

    public function horariosEventuales(): HasMany
    {
        return $this->hasMany(HorarioEventual::class);
    }
}

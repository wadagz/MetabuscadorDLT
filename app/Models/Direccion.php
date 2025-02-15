<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Direccion extends Model
{
    /** @use HasFactory<\Database\Factories\DireccionFactory> */
    use HasFactory;

    protected $table = 'direcciones';

    public function tipoVialidad(): BelongsTo
    {
        return $this->belongsTo(TipoVialidad::class);
    }

    public function asentamiento(): BelongsTo
    {
        return $this->belongsTo(Asentamiento::class);
    }

    public function hospedaje(): HasOne
    {
        return $this->hasOne(Hospedaje::class);
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }

    public function lugarInteres(): HasOne
    {
        return $this->hasOne(LugarInteres::class);
    }

    public function municipio(): HasOneThrough
    {
        return $this->hasOneThrough(Municipio::class, Asentamiento::class);
    }

}

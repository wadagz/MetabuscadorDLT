<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LugarInteres extends Model
{
    /** @use HasFactory<\Database\Factories\LugarInteresFactory> */
    use HasFactory;

    protected $table = 'lugares_interes';

    public function destino(): BelongsTo
    {
        return $this->belongsTo(Destino::class);
    }

    public function direccion(): HasOne
    {
        return $this->hasOne(Direccion::class);
    }

    public function horarios(): HasMany
    {
        return $this->hasMany(HorarioSemanal::class);
    }

}

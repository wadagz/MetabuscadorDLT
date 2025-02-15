<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destino extends Model
{
    /** @use HasFactory<\Database\Factories\DestinoFactory> */
    use HasFactory;

    protected $table = 'destinos';

    public function hospedajes(): HasMany
    {
        return $this->hasMany(Hospedaje::class);
    }

    public function lugaresInteres(): HasMany
    {
        return $this->hasMany(LugarInteres::class);
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }

}

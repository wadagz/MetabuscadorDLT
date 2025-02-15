<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hospedaje extends Model
{
    /** @use HasFactory<\Database\Factories\HospedajeFactory> */
    use HasFactory;

    protected $table = "hospedajes";

    public function tipoHospedaje(): BelongsTo
    {
        return $this->belongsTo(TipoHospedaje::class);
    }

    public function propietario(): BelongsTo
    {
        return $this->belongsTo(Propietario::class);
    }

    public function amenidades(): BelongsToMany
    {
        return $this->belongsToMany(
            Amenidad::class,
            'amenidad_hospedaje',
            'hospedaje_id',
            'amenidad_id'
        );
    }

    public function usuariosQueDieronFavorito(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            table: 'favoritos_hospedaje_usuario'
        );
    }

    public function destino(): BelongsTo
    {
        return $this->belongsTo(Destino::class);
    }

    public function direccion(): HasOne
    {
        return $this->hasOne(Direccion::class);
    }

    # TODO:
    # Viajes
    # Estructurar sistema de reseñas
    // public function resenas(): HasMany
    // {
    //     return $this->hasMany(resena::class);
    // }
}

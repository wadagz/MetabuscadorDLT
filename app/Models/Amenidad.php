<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenidad extends Model
{
    /** @use HasFactory<\Database\Factories\AmenidadFactory> */
    use HasFactory;

    protected $table = 'amenidades';

    public function hospedajes(): BelongsToMany
    {
        return $this->belongsToMany(
            Hospedaje::class,
            'amenidad_hospedaje',
            'amenidad_id',
            'hospedaje_id'
        );
    }
}

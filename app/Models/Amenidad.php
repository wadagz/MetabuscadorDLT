<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenidad extends Model
{
    /** @use HasFactory<\Database\Factories\AmenidadFactory> */
    use HasFactory;
    use Filterable;
    use Sortable;

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

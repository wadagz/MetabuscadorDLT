<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TipoHospedaje extends Model
{
    /** @use HasFactory<\Database\Factories\TipoHospedajeFactory> */
    use HasFactory;

    protected $table = 'tipo_hospedajes';

    public $timestamps = false;

    /**
     * @return BelongsTo<Hospedaje,TipoHospedaje>
     */
    public function hospedaje(): BelongsTo
    {
        return $this->belongsTo(Hospedaje::class);
    }
}

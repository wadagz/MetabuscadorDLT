<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asentamiento extends Model
{
    protected $table = 'asentamientos';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;


    public function tipoAsentamiento(): BelongsTo
    {
        return $this->belongsTo(TipoAsentamiento::class);
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class);
    }

}

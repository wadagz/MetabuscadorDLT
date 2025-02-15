<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id');
    }

    public function codigosPostales(): HasMany
    {
        return $this->hasMany(CodigoPostal::class);
    }

}

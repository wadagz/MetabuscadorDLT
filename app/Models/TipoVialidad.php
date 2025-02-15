<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoVialidad extends Model
{
    protected $table = 'tipos_vialidad';
    public $timestamps = false;

    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class);
    }
}

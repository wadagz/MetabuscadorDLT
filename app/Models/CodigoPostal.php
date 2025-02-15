<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodigoPostal extends Model
{
    protected $table = 'codigos_postales';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }
}

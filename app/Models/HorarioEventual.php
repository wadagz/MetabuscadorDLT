<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioEventual extends Model
{
    /** @use HasFactory<\Database\Factories\HorarioEventualFactory> */
    use HasFactory;

    protected $table = 'horarios_eventuales';

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}

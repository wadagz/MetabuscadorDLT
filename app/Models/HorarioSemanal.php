<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioSemanal extends Model
{
    /** @use HasFactory<\Database\Factories\HorarioSemanalFactory> */
    use HasFactory;

    protected $table = 'horarios_semanales';

    public function lugarInteres(): BelongsTo
    {
        return $this->belongsTo(LugarInteres::class);
    }
}

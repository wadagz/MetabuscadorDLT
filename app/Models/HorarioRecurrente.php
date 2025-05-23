<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioRecurrente extends Model
{
    /** @use HasFactory<\Database\Factories\HorarioSemanalFactory> */
    use HasFactory;

    protected $table = 'horarios_recurrentes';

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class);
    }
}

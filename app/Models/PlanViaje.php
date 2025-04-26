<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanViaje extends Model
{
    protected $table = 'planes_viaje';

    protected $fillable = [
        'user_id',
        'hospedaje_id',
        'fecha_comienzo',
        'fecha_fin'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hospedaje(): BelongsTo
    {
        return $this->belongsTo(Hospedaje::class);
    }

    public function itinerarios(): HasMany
    {
        return $this->hasMany(Itinerario::class);
    }
}

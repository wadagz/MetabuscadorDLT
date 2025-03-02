<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Preferencia extends Model
{
    /** @use HasFactory<\Database\Factories\PreferenciaFactory> */
    use HasFactory;

    protected $table = 'preferencias';

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            table: 'preferencias_usuarios'
        );
    }
}

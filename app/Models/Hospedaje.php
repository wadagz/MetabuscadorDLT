<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hospedaje extends Model
{
    /** @use HasFactory<\Database\Factories\HospedajeFactory> */
    use HasFactory;
    use Filterable;
    use Sortable;

    protected $table = "hospedajes";

    protected $fillable = [
        'nombre',
        'precio',
        'url',
        'tipo_hospedaje_id',
        'propietario_id',
        'destino_id',
        'direccion_id',
    ];

    public function tipoHospedaje(): BelongsTo
    {
        return $this->belongsTo(TipoHospedaje::class);
    }

    public function propietario(): BelongsTo
    {
        return $this->belongsTo(Propietario::class);
    }

    public function amenidades(): BelongsToMany
    {
        return $this->belongsToMany(
            Amenidad::class,
            'amenidad_hospedaje',
            'hospedaje_id',
            'amenidad_id'
        );
    }

    public function usuariosQueDieronFavorito(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            table: 'favoritos_hospedaje_usuario'
        );
    }

    public function destino(): BelongsTo
    {
        return $this->belongsTo(Destino::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class);
    }

    public function usuariosQueVieronRecientemente(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            table: 'vistos_reciente'
        );
    }

    public function resenasDeUsuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            table: 'resenas_hospedaje',
        )->withPivot([
            'comentario',
            'calificacion',
            'user_id',
            'hospedaje_id',
            'fecha',
            'created_at',
            'updated_at',
        ]);
    }

    # TODO:
    # Viajes
}

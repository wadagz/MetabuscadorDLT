<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hospedajesFavoritos(): BelongsToMany
    {
        return $this->belongsToMany(
            Hospedaje::class,
            table: 'favoritos_hospedaje_usuario'
        );
    }

    public function preferencias(): BelongsToMany
    {
        return $this->belongsToMany(
            Preferencia::class,
            table: 'preferencias_usuarios'
        );
    }

    public function vistosReciente(): BelongsToMany
    {
        return $this->belongsToMany(
            Hospedaje::class,
            table: 'vistos_reciente'
        )->withTimestamps();;
    }

    public function resenasTransporte(): BelongsToMany
    {
        return $this->belongsToMany(
            RutaTransporte::class,
            'resenas_transporte',
            'user_id',
            'ruta_transporte_id'
        )->withPivot(
            [
                'calificacion',
                'comentario',
                'created_at',
                'updated_at'
            ]
        );
    }

    public function resenasHopedajes(): BelongsToMany
    {
        return $this->belongsToMany(
            Hospedaje::class,
            table: 'resenas_hospedaje',
        )->withPivot([
            'id',
            'comentario',
            'calificacion',
            'user_id',
            'hospedaje_id',
            'fecha',
            'created_at',
            'updated_at',
        ]);
    }
}

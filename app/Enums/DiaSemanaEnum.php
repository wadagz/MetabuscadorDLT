<?php

namespace App\Enums;

enum DiaSemanaEnum: int
{
    case DOMINGO = 0;
    case LUNES = 1;
    case MARTES = 2;
    case MIERCOLES = 3;
    case JUEVES = 4;
    case VIERNES = 5;
    case SABADO = 6;

    /**
     * Get the description of the activity type.
     */
    public function nombre(): string
    {
        return match($this) {
            self::DOMINGO => 'Domingo',
            self::LUNES => 'Lunes',
            self::MARTES => 'Martes',
            self::MIERCOLES => 'Miércoles',
            self::JUEVES => 'Jueves',
            self::VIERNES => 'Viernes',
            self::SABADO => 'Sábado',
        };
    }

    /**
     * Get all activity types as an array for select options.
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'nombre' => $case->nombre(),
        ], self::cases());
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}


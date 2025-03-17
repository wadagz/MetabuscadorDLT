<?php

namespace App\Enums;

enum TipoHospedajeEnum: int
{
    case HOTEL = 1;
    case HOSTAL = 2;
    case CASA_HUESPEDES = 3;
    case APARTAMENTO = 4;
    case CABAÑA = 5;
    case CAMPING = 6;
    case RESORT = 7;
    case MOTEL = 8;
    case POSADA = 9;
    case CASA_RURAL = 10;
    case ALBERGUE = 11;
    case VILLA = 12;
    case BUNGALOW = 13;
    case HACIENDA = 14;
    case GLAMPING = 15;

    /**
     * Get the description of the accommodation type.
     */
    public function descripcion(): string
    {
        return match($this) {
            self::HOTEL => 'Hotel',
            self::HOSTAL => 'Hostal',
            self::CASA_HUESPEDES => 'Casa de Huéspedes',
            self::APARTAMENTO => 'Apartamento',
            self::CABAÑA => 'Cabaña',
            self::CAMPING => 'Camping',
            self::RESORT => 'Resort',
            self::MOTEL => 'Motel',
            self::POSADA => 'Posada',
            self::CASA_RURAL => 'Casa Rural',
            self::ALBERGUE => 'Albergue',
            self::VILLA => 'Villa',
            self::BUNGALOW => 'Bungalow',
            self::HACIENDA => 'Hacienda',
            self::GLAMPING => 'Glamping',
        };
    }

    /**
     * Get all accommodation types as an array for select options.
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'descripcion' => $case->descripcion(),
        ], self::cases());
    }
} 
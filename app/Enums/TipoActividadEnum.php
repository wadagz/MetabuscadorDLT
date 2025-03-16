<?php

namespace App\Enums;

enum TipoActividadEnum: int
{
    case TOUR = 1;
    case EXCURSION = 2;
    case VISITA_GUIADA = 3;
    case AVENTURA = 4;
    case GASTRONOMIA = 5;
    case CULTURAL = 6;
    case DEPORTIVA = 7;
    case EDUCATIVA = 8;
    case RECREATIVA = 9;
    case RELIGIOSA = 10;
    case ECOTURISMO = 11;
    case FESTIVAL = 12;
    case CONCIERTO = 13;
    case EXPOSICION = 14;
    case TALLER = 15;
    case CONFERENCIA = 16;
    case FERIA = 17;
    case MERCADO = 18;
    case PLAYA = 19;
    case PARQUE_TEMATICO = 20;

    /**
     * Get the description of the activity type.
     */
    public function descripcion(): string
    {
        return match($this) {
            self::TOUR => 'Tour',
            self::EXCURSION => 'Excursión',
            self::VISITA_GUIADA => 'Visita Guiada',
            self::AVENTURA => 'Aventura',
            self::GASTRONOMIA => 'Gastronomía',
            self::CULTURAL => 'Cultural',
            self::DEPORTIVA => 'Deportiva',
            self::EDUCATIVA => 'Educativa',
            self::RECREATIVA => 'Recreativa',
            self::RELIGIOSA => 'Religiosa',
            self::ECOTURISMO => 'Ecoturismo',
            self::FESTIVAL => 'Festival',
            self::CONCIERTO => 'Concierto',
            self::EXPOSICION => 'Exposición',
            self::TALLER => 'Taller',
            self::CONFERENCIA => 'Conferencia',
            self::FERIA => 'Feria',
            self::MERCADO => 'Mercado',
            self::PLAYA => 'Playa',
            self::PARQUE_TEMATICO => 'Parque Temático',
        };
    }

    /**
     * Get all activity types as an array for select options.
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'descripcion' => $case->descripcion(),
        ], self::cases());
    }
} 
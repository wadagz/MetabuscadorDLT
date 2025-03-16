<?php

namespace App\Enums;

enum TipoVialidadEnum: int
{
    case AMPLIACION = 1;
    case ANDADOR = 2;
    case AVENIDA = 3;
    case BOULEVARD = 4;
    case CALLE = 5;
    case CALLEJON = 6;
    case CALZADA = 7;
    case CERRADA = 8;
    case CIRCUITO = 9;
    case CIRCUNVALACION = 10;
    case CONTINUACION = 11;
    case CORREDOR = 12;
    case DIAGONAL = 13;
    case EJE_VIAL = 14;
    case PASAJE = 15;
    case PEATONAL = 16;
    case PERIFERICO = 17;
    case PRIVADA = 18;
    case PROLONGACION = 19;
    case RETORNO = 20;
    case VIADUCTO = 21;

    /**
     * Get the description of the road type.
     */
    public function descripcion(): string
    {
        return match($this) {
            self::AMPLIACION => 'Ampliación',
            self::ANDADOR => 'Andador',
            self::AVENIDA => 'Avenida',
            self::BOULEVARD => 'Boulevard',
            self::CALLE => 'Calle',
            self::CALLEJON => 'Callejón',
            self::CALZADA => 'Calzada',
            self::CERRADA => 'Cerrada',
            self::CIRCUITO => 'Circuito',
            self::CIRCUNVALACION => 'Circunvalación',
            self::CONTINUACION => 'Continuación',
            self::CORREDOR => 'Corredor',
            self::DIAGONAL => 'Diagonal',
            self::EJE_VIAL => 'Eje Vial',
            self::PASAJE => 'Pasaje',
            self::PEATONAL => 'Peatonal',
            self::PERIFERICO => 'Periférico',
            self::PRIVADA => 'Privada',
            self::PROLONGACION => 'Prolongación',
            self::RETORNO => 'Retorno',
            self::VIADUCTO => 'Viaducto',
        };
    }

    /**
     * Get all road types as an array for select options.
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'descripcion' => $case->descripcion(),
        ], self::cases());
    }
} 
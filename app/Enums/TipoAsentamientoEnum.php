<?php

namespace App\Enums;

enum TipoAsentamientoEnum: int
{
    case AEROPUERTO = 1;
    case AMPLIACION = 2;
    case BARRIO = 3;
    case CANTON = 4;
    case CIUDAD = 5;
    case CIUDAD_INDUSTRIAL = 6;
    case COLONIA = 7;
    case CONDOMINIO = 8;
    case CONJUNTO_HABITACIONAL = 9;
    case CORREDOR_INDUSTRIAL = 10;
    case COTO = 11;
    case CUARTEL = 12;
    case EJIDO = 13;
    case EXHACIENDA = 14;
    case FRACCION = 15;
    case FRACCIONAMIENTO = 16;
    case GRANJA = 17;
    case HACIENDA = 18;
    case INGENIO = 19;
    case MANZANA = 20;
    case PARAJE = 21;
    case PARQUE_INDUSTRIAL = 22;
    case PRIVADA = 23;
    case PROLONGACION = 24;
    case PUEBLO = 25;
    case PUERTO = 26;
    case RANCHERIA = 27;
    case RANCHO = 28;
    case REGION = 29;
    case RESIDENCIAL = 30;
    case RINCONADA = 31;
    case SECCION = 32;
    case SECTOR = 33;
    case SUPERMANZANA = 34;
    case UNIDAD = 35;
    case UNIDAD_HABITACIONAL = 36;
    case VILLA = 37;
    case ZONA_FEDERAL = 38;
    case ZONA_INDUSTRIAL = 39;
    case ZONA_MILITAR = 40;
    case ZONA_NAVAL = 41;

    /**
     * Get the description of the settlement type.
     */
    public function descripcion(): string
    {
        return match($this) {
            self::AEROPUERTO => 'Aeropuerto',
            self::AMPLIACION => 'Ampliación',
            self::BARRIO => 'Barrio',
            self::CANTON => 'Cantón',
            self::CIUDAD => 'Ciudad',
            self::CIUDAD_INDUSTRIAL => 'Ciudad Industrial',
            self::COLONIA => 'Colonia',
            self::CONDOMINIO => 'Condominio',
            self::CONJUNTO_HABITACIONAL => 'Conjunto Habitacional',
            self::CORREDOR_INDUSTRIAL => 'Corredor Industrial',
            self::COTO => 'Coto',
            self::CUARTEL => 'Cuartel',
            self::EJIDO => 'Ejido',
            self::EXHACIENDA => 'Exhacienda',
            self::FRACCION => 'Fracción',
            self::FRACCIONAMIENTO => 'Fraccionamiento',
            self::GRANJA => 'Granja',
            self::HACIENDA => 'Hacienda',
            self::INGENIO => 'Ingenio',
            self::MANZANA => 'Manzana',
            self::PARAJE => 'Paraje',
            self::PARQUE_INDUSTRIAL => 'Parque Industrial',
            self::PRIVADA => 'Privada',
            self::PROLONGACION => 'Prolongación',
            self::PUEBLO => 'Pueblo',
            self::PUERTO => 'Puerto',
            self::RANCHERIA => 'Ranchería',
            self::RANCHO => 'Rancho',
            self::REGION => 'Región',
            self::RESIDENCIAL => 'Residencial',
            self::RINCONADA => 'Rinconada',
            self::SECCION => 'Sección',
            self::SECTOR => 'Sector',
            self::SUPERMANZANA => 'Supermanzana',
            self::UNIDAD => 'Unidad',
            self::UNIDAD_HABITACIONAL => 'Unidad Habitacional',
            self::VILLA => 'Villa',
            self::ZONA_FEDERAL => 'Zona Federal',
            self::ZONA_INDUSTRIAL => 'Zona Industrial',
            self::ZONA_MILITAR => 'Zona Militar',
            self::ZONA_NAVAL => 'Zona Naval',
        };
    }

    /**
     * Get all settlement types as an array for select options.
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'descripcion' => $case->descripcion(),
        ], self::cases());
    }
} 
<?php

namespace App\Enums;

enum EstadoEnum: int
{
    case AGUASCALIENTES = 1;
    case BAJA_CALIFORNIA = 2;
    case BAJA_CALIFORNIA_SUR = 3;
    case CAMPECHE = 4;
    case COAHUILA = 5;
    case COLIMA = 6;
    case CHIAPAS = 7;
    case CHIHUAHUA = 8;
    case CIUDAD_DE_MEXICO = 9;
    case DURANGO = 10;
    case GUANAJUATO = 11;
    case GUERRERO = 12;
    case HIDALGO = 13;
    case JALISCO = 14;
    case MEXICO = 15;
    case MICHOACAN = 16;
    case MORELOS = 17;
    case NAYARIT = 18;
    case NUEVO_LEON = 19;
    case OAXACA = 20;
    case PUEBLA = 21;
    case QUERETARO = 22;
    case QUINTANA_ROO = 23;
    case SAN_LUIS_POTOSI = 24;
    case SINALOA = 25;
    case SONORA = 26;
    case TABASCO = 27;
    case TAMAULIPAS = 28;
    case TLAXCALA = 29;
    case VERACRUZ = 30;
    case YUCATAN = 31;
    case ZACATECAS = 32;

    /**
     * Get the name of the state.
     */
    public function nombre(): string
    {
        return match($this) {
            self::AGUASCALIENTES => 'Aguascalientes',
            self::BAJA_CALIFORNIA => 'Baja California',
            self::BAJA_CALIFORNIA_SUR => 'Baja California Sur',
            self::CAMPECHE => 'Campeche',
            self::COAHUILA => 'Coahuila',
            self::COLIMA => 'Colima',
            self::CHIAPAS => 'Chiapas',
            self::CHIHUAHUA => 'Chihuahua',
            self::CIUDAD_DE_MEXICO => 'Ciudad de México',
            self::DURANGO => 'Durango',
            self::GUANAJUATO => 'Guanajuato',
            self::GUERRERO => 'Guerrero',
            self::HIDALGO => 'Hidalgo',
            self::JALISCO => 'Jalisco',
            self::MEXICO => 'México',
            self::MICHOACAN => 'Michoacán',
            self::MORELOS => 'Morelos',
            self::NAYARIT => 'Nayarit',
            self::NUEVO_LEON => 'Nuevo León',
            self::OAXACA => 'Oaxaca',
            self::PUEBLA => 'Puebla',
            self::QUERETARO => 'Querétaro',
            self::QUINTANA_ROO => 'Quintana Roo',
            self::SAN_LUIS_POTOSI => 'San Luis Potosí',
            self::SINALOA => 'Sinaloa',
            self::SONORA => 'Sonora',
            self::TABASCO => 'Tabasco',
            self::TAMAULIPAS => 'Tamaulipas',
            self::TLAXCALA => 'Tlaxcala',
            self::VERACRUZ => 'Veracruz',
            self::YUCATAN => 'Yucatán',
            self::ZACATECAS => 'Zacatecas',
        };
    }

    /**
     * Get the abbreviation of the state.
     */
    public function abreviatura(): string
    {
        return match($this) {
            self::AGUASCALIENTES => 'AGS',
            self::BAJA_CALIFORNIA => 'BC',
            self::BAJA_CALIFORNIA_SUR => 'BCS',
            self::CAMPECHE => 'CAMP',
            self::COAHUILA => 'COAH',
            self::COLIMA => 'COL',
            self::CHIAPAS => 'CHIS',
            self::CHIHUAHUA => 'CHIH',
            self::CIUDAD_DE_MEXICO => 'CDMX',
            self::DURANGO => 'DGO',
            self::GUANAJUATO => 'GTO',
            self::GUERRERO => 'GRO',
            self::HIDALGO => 'HGO',
            self::JALISCO => 'JAL',
            self::MEXICO => 'MEX',
            self::MICHOACAN => 'MICH',
            self::MORELOS => 'MOR',
            self::NAYARIT => 'NAY',
            self::NUEVO_LEON => 'NL',
            self::OAXACA => 'OAX',
            self::PUEBLA => 'PUE',
            self::QUERETARO => 'QRO',
            self::QUINTANA_ROO => 'QROO',
            self::SAN_LUIS_POTOSI => 'SLP',
            self::SINALOA => 'SIN',
            self::SONORA => 'SON',
            self::TABASCO => 'TAB',
            self::TAMAULIPAS => 'TAMPS',
            self::TLAXCALA => 'TLAX',
            self::VERACRUZ => 'VER',
            self::YUCATAN => 'YUC',
            self::ZACATECAS => 'ZAC',
        };
    }

    /**
     * Get all states as an array for select options.
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'nombre' => $case->nombre(),
            'abreviatura' => $case->abreviatura(),
        ], self::cases());
    }
} 
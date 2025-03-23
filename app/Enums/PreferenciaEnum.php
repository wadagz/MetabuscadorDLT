<?php

namespace App\Enums;

enum PreferenciaEnum: int
{
    // Pregunta 1
    case PREG_1_OPT_A = 1;
    case PREG_1_OPT_B = 2;
    case PREG_1_OPT_C = 3;
    case PREG_1_OPT_D = 4;
    case PREG_1_OPT_E = 5;

    // Pregunta 2
    case PREG_2_OPT_A = 6;
    case PREG_2_OPT_B = 7;
    case PREG_2_OPT_C = 8;
    case PREG_2_OPT_D = 9;
    case PREG_2_OPT_E = 10;

    // Pregunta 3
    case PREG_3_OPT_A = 11;
    case PREG_3_OPT_B = 12;
    case PREG_3_OPT_C = 13;
    case PREG_3_OPT_D = 14;
    case PREG_3_OPT_E = 15;

    // Pregunta 4
    case PREG_4_OPT_A = 16;
    case PREG_4_OPT_B = 17;
    case PREG_4_OPT_C = 18;
    case PREG_4_OPT_D = 19;
    case PREG_4_OPT_E = 20;

    // Pregunta 5
    case PREG_5_OPT_A = 21;
    case PREG_5_OPT_B = 22;
    case PREG_5_OPT_C = 23;
    case PREG_5_OPT_D = 24;
    case PREG_5_OPT_E = 25;

    /**
     * Get the description of the preferencia.
     */
    public function descripcion(): string
    {
        return match($this) {
            // Pregunta 1
            self::PREG_1_OPT_A => 'Tranquilo y relajado',
            self::PREG_1_OPT_B => 'Animado y con mucha actividad',
            self::PREG_1_OPT_C => 'Lujo y exclusividad',
            self::PREG_1_OPT_D => 'Familiar y acogedor',
            self::PREG_1_OPT_E => 'Moderno y minimalista',
            // Pregunta 2
            self::PREG_2_OPT_A => 'Wi-Fi gratis',
            self::PREG_2_OPT_B => 'Piscina y gimnasio',
            self::PREG_2_OPT_C => 'Restaurante o bar dentro del hotel',
            self::PREG_2_OPT_D => 'Estacionamiento gratuito',
            self::PREG_2_OPT_E => 'Servicio de limpieza diario',
            // Pregunta 3
            self::PREG_3_OPT_A => 'El precio es lo más importante, busco lo más económico',
            self::PREG_3_OPT_B => 'Busco una buen arelación calidad-precio',
            self::PREG_3_OPT_C => 'No me importa el procio si la calidad es excelente',
            self::PREG_3_OPT_D => 'Estoy dispuesto a pagar un poco más por mayor comodidad',
            self::PREG_3_OPT_E => 'El precio no me importa tanto si hay ofertas especiales',
            // Pregunta 4
            self::PREG_4_OPT_A => 'Muy importante, busco alojamientos ecológicos y sostenibles',
            self::PREG_4_OPT_B => 'Algo importante, prefiero alojamientos con prácticas verdes',
            self::PREG_4_OPT_C => 'No es tan relevante, pero si es una opción, lo prefiero',
            self::PREG_4_OPT_D => 'No me importa mucho, me enfoco más en la comodidad',
            self::PREG_4_OPT_E => 'No me interesa en absoluto la sostenibilidad',
            // Pregunta 5
            self::PREG_5_OPT_A => 'Muy importante, necesito acceso fácil a transporte público',
            self::PREG_5_OPT_B => 'Algo importante, pero no es un factor decisivo',
            self::PREG_5_OPT_C => 'No me importa tanto, puedo caminar o tomar un taxi',
            self::PREG_5_OPT_D => 'No me interesa, prefiero alojarme en lugares remotos',
            self::PREG_5_OPT_E => 'No me importa, tengo mi propio vehículo',
        };
    }

    /**
     * Get the name of the preferencia.
     */
    public function nombre(): string
    {
        return match($this) {
            //Pregunta 1
            self::PREG_1_OPT_A => 'preg1OptA',
            self::PREG_1_OPT_B => 'preg1OptB',
            self::PREG_1_OPT_C => 'preg1OptC',
            self::PREG_1_OPT_D => 'preg1OptD',
            self::PREG_1_OPT_E => 'preg1OptE',
            //Pregunta 2
            self::PREG_2_OPT_A => 'preg2OptA',
            self::PREG_2_OPT_B => 'preg2OptB',
            self::PREG_2_OPT_C => 'preg2OptC',
            self::PREG_2_OPT_D => 'preg2OptD',
            self::PREG_2_OPT_E => 'preg2OptE',
            //Pregunta 3
            self::PREG_3_OPT_A => 'preg3OptA',
            self::PREG_3_OPT_B => 'preg3OptB',
            self::PREG_3_OPT_C => 'preg3OptC',
            self::PREG_3_OPT_D => 'preg3OptD',
            self::PREG_3_OPT_E => 'preg3OptE',
            //Pregunta 4
            self::PREG_4_OPT_A => 'preg4OptA',
            self::PREG_4_OPT_B => 'preg4OptB',
            self::PREG_4_OPT_C => 'preg4OptC',
            self::PREG_4_OPT_D => 'preg4OptD',
            self::PREG_4_OPT_E => 'preg4OptE',
            //Pregunta 5
            self::PREG_5_OPT_A => 'preg5OptA',
            self::PREG_5_OPT_B => 'preg5OptB',
            self::PREG_5_OPT_C => 'preg5OptC',
            self::PREG_5_OPT_D => 'preg5OptD',
            self::PREG_5_OPT_E => 'preg5OptE',
        };
    }

    /**
     * Retorna un arreglo con los datos de los cases correspondientes
     * al número de pregunta provisto en el parámetro $number.
     *
     * @param int $number Número de la pregunta.
     * @return array Arreglo de arreglos asociativos con las llaves 'id', 'nombre', 'descripcion'.
     */
    public static function numPregunta(int $number): array
    {
        $casesPerRange = 5;
        $startIndex = ($number - 1) * $casesPerRange;
        $allCases = PreferenciaEnum::cases();
        $casesToReturn = array_slice($allCases, $startIndex, $casesPerRange);

        return array_map(fn($case) => [
            'id' => $case->value,
            'nombre' => $case->nombre(),
            'descripcion' => $case->descripcion(),
        ], $casesToReturn);
    }

    /**
     * Get preferencias as an associative array.
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'nombre' => $case->nombre(),
            'descripcion' => $case->descripcion(),
        ], self::cases());
    }
}

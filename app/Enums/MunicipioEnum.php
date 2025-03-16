<?php

namespace App\Enums;

use InvalidArgumentException;

enum MunicipioEnum: int
{
    // Aguascalientes (1-11)
    case AGUASCALIENTES = 1;
    case ASIENTOS = 2;
    case CALVILLO = 3;
    case COSIO = 4;
    case JESUS_MARIA = 5;
    case PABELLON_DE_ARTEAGA = 6;
    case RINCON_DE_ROMOS = 7;
    case SAN_JOSE_DE_GRACIA = 8;
    case TEPEZALA = 9;
    case EL_LLANO = 10;
    case SAN_FRANCISCO_DE_LOS_ROMO = 11;

    // Baja California (12-16)
    case ENSENADA = 12;
    case MEXICALI = 13;
    case TECATE = 14;
    case TIJUANA = 15;
    case PLAYAS_DE_ROSARITO = 16;

    // Baja California Sur (17-21)
    case COMONDU = 17;
    case MULEGE = 18;
    case LA_PAZ = 19;
    case LOS_CABOS = 20;
    case LORETO = 21;

    // Campeche (22-32)
    case CALKINI = 22;
    case CAMPECHE = 23;
    case CARMEN = 24;
    case CHAMPOTON = 25;
    case HECELCHAKAN = 26;
    case HOPELCHEN = 27;
    case PALIZADA = 28;
    case TENABO = 29;
    case ESCARCEGA = 30;
    case CALAKMUL = 31;
    case CANDELARIA = 32;

    // Coahuila (33-70)
    case ABASOLO_COAH = 33;
    case ACUNA = 34;
    case ALLENDE_COAH = 35;
    case ARTEAGA = 36;
    case CANDELA = 37;
    case CASTANOS = 38;
    case CUATRO_CIENEGAS = 39;
    case ESCOBEDO_COAH = 40;
    case FRANCISCO_I_MADERO = 41;
    case FRONTERA = 42;
    case GENERAL_CEPEDA = 43;
    case GUERRERO_COAH = 44;
    case HIDALGO_COAH = 45;
    case JIMENEZ_COAH = 46;
    case JUAREZ_COAH = 47;
    case LAMADRID = 48;
    case MATAMOROS_COAH = 49;
    case MONCLOVA = 50;
    case MORELOS_COAH = 51;
    case MUZQUIZ = 52;
    case NADADORES = 53;
    case NAVA = 54;
    case OCAMPO_COAH = 55;
    case PARRAS = 56;
    case PIEDRAS_NEGRAS = 57;
    case PROGRESO_COAH = 58;
    case RAMOS_ARIZPE = 59;
    case SABINAS = 60;
    case SACRAMENTO = 61;
    case SALTILLO = 62;
    case SAN_BUENAVENTURA = 63;
    case SAN_JUAN_DE_SABINAS = 64;
    case SAN_PEDRO_COAH = 65;
    case SIERRA_MOJADA = 66;
    case TORREON = 67;
    case VIESCA = 68;
    case VILLA_UNION = 69;
    case ZARAGOZA_COAH = 70;

    // Colima (71-80)
    case ARMERIA = 71;
    case COLIMA = 72;
    case COMALA = 73;
    case COQUIMATLAN = 74;
    case CUAUHTEMOC_COL = 75;
    case IXTLAHUACAN_COL = 76;
    case MANZANILLO = 77;
    case MINATITLAN_COL = 78;
    case TECOMAN = 79;
    case VILLA_DE_ALVAREZ = 80;

    // Chiapas (81-100)
    case ACACOYAGUA = 81;
    case ACALA = 82;
    case ACAPETAHUA = 83;
    case ALTAMIRANO = 84;
    case AMATAN = 85;
    case AMATENANGO_DE_LA_FRONTERA = 86;
    case AMATENANGO_DEL_VALLE = 87;
    case ANGEL_ALBINO_CORZO = 88;
    case ARRIAGA = 89;
    case BEJUCAL_DE_OCAMPO = 90;
    case BELLA_VISTA = 91;
    case BERRIOZABAL = 92;
    case BOCHIL = 93;
    case EL_BOSQUE = 94;
    case CACAHOATAN = 95;
    case CATAZAJA = 96;
    case CINTALAPA = 97;
    case COAPILLA = 98;
    case COMITAN_DE_DOMINGUEZ = 99;
    case LA_CONCORDIA = 100;

    // ... More municipalities would be added here
    // For brevity, I'm only including a subset of municipalities

    /**
     * Get the name of the municipality.
     */
    public function nombre(): string
    {
        return match($this) {
            // Aguascalientes
            self::AGUASCALIENTES => 'Aguascalientes',
            self::ASIENTOS => 'Asientos',
            self::CALVILLO => 'Calvillo',
            self::COSIO => 'Cosío',
            self::JESUS_MARIA => 'Jesús María',
            self::PABELLON_DE_ARTEAGA => 'Pabellón de Arteaga',
            self::RINCON_DE_ROMOS => 'Rincón de Romos',
            self::SAN_JOSE_DE_GRACIA => 'San José de Gracia',
            self::TEPEZALA => 'Tepezalá',
            self::EL_LLANO => 'El Llano',
            self::SAN_FRANCISCO_DE_LOS_ROMO => 'San Francisco de los Romo',
            
            // Baja California
            self::ENSENADA => 'Ensenada',
            self::MEXICALI => 'Mexicali',
            self::TECATE => 'Tecate',
            self::TIJUANA => 'Tijuana',
            self::PLAYAS_DE_ROSARITO => 'Playas de Rosarito',
            
            // Baja California Sur
            self::COMONDU => 'Comondú',
            self::MULEGE => 'Mulegé',
            self::LA_PAZ => 'La Paz',
            self::LOS_CABOS => 'Los Cabos',
            self::LORETO => 'Loreto',
            
            // Campeche
            self::CALKINI => 'Calkiní',
            self::CAMPECHE => 'Campeche',
            self::CARMEN => 'Carmen',
            self::CHAMPOTON => 'Champotón',
            self::HECELCHAKAN => 'Hecelchakán',
            self::HOPELCHEN => 'Hopelchén',
            self::PALIZADA => 'Palizada',
            self::TENABO => 'Tenabo',
            self::ESCARCEGA => 'Escárcega',
            self::CALAKMUL => 'Calakmul',
            self::CANDELARIA => 'Candelaria',
            
            // Coahuila
            self::ABASOLO_COAH => 'Abasolo',
            self::ACUNA => 'Acuña',
            self::ALLENDE_COAH => 'Allende',
            self::ARTEAGA => 'Arteaga',
            self::CANDELA => 'Candela',
            self::CASTANOS => 'Castaños',
            self::CUATRO_CIENEGAS => 'Cuatro Ciénegas',
            self::ESCOBEDO_COAH => 'Escobedo',
            self::FRANCISCO_I_MADERO => 'Francisco I. Madero',
            self::FRONTERA => 'Frontera',
            self::GENERAL_CEPEDA => 'General Cepeda',
            self::GUERRERO_COAH => 'Guerrero',
            self::HIDALGO_COAH => 'Hidalgo',
            self::JIMENEZ_COAH => 'Jiménez',
            self::JUAREZ_COAH => 'Juárez',
            self::LAMADRID => 'Lamadrid',
            self::MATAMOROS_COAH => 'Matamoros',
            self::MONCLOVA => 'Monclova',
            self::MORELOS_COAH => 'Morelos',
            self::MUZQUIZ => 'Múzquiz',
            self::NADADORES => 'Nadadores',
            self::NAVA => 'Nava',
            self::OCAMPO_COAH => 'Ocampo',
            self::PARRAS => 'Parras',
            self::PIEDRAS_NEGRAS => 'Piedras Negras',
            self::PROGRESO_COAH => 'Progreso',
            self::RAMOS_ARIZPE => 'Ramos Arizpe',
            self::SABINAS => 'Sabinas',
            self::SACRAMENTO => 'Sacramento',
            self::SALTILLO => 'Saltillo',
            self::SAN_BUENAVENTURA => 'San Buenaventura',
            self::SAN_JUAN_DE_SABINAS => 'San Juan de Sabinas',
            self::SAN_PEDRO_COAH => 'San Pedro',
            self::SIERRA_MOJADA => 'Sierra Mojada',
            self::TORREON => 'Torreón',
            self::VIESCA => 'Viesca',
            self::VILLA_UNION => 'Villa Unión',
            self::ZARAGOZA_COAH => 'Zaragoza',
            
            // Colima
            self::ARMERIA => 'Armería',
            self::COLIMA => 'Colima',
            self::COMALA => 'Comala',
            self::COQUIMATLAN => 'Coquimatlán',
            self::CUAUHTEMOC_COL => 'Cuauhtémoc',
            self::IXTLAHUACAN_COL => 'Ixtlahuacán',
            self::MANZANILLO => 'Manzanillo',
            self::MINATITLAN_COL => 'Minatitlán',
            self::TECOMAN => 'Tecomán',
            self::VILLA_DE_ALVAREZ => 'Villa de Álvarez',
            
            // Chiapas (partial)
            self::ACACOYAGUA => 'Acacoyagua',
            self::ACALA => 'Acala',
            self::ACAPETAHUA => 'Acapetahua',
            self::ALTAMIRANO => 'Altamirano',
            self::AMATAN => 'Amatán',
            self::AMATENANGO_DE_LA_FRONTERA => 'Amatenango de la Frontera',
            self::AMATENANGO_DEL_VALLE => 'Amatenango del Valle',
            self::ANGEL_ALBINO_CORZO => 'Ángel Albino Corzo',
            self::ARRIAGA => 'Arriaga',
            self::BEJUCAL_DE_OCAMPO => 'Bejucal de Ocampo',
            self::BELLA_VISTA => 'Bella Vista',
            self::BERRIOZABAL => 'Berriozábal',
            self::BOCHIL => 'Bochil',
            self::EL_BOSQUE => 'El Bosque',
            self::CACAHOATAN => 'Cacahoatán',
            self::CATAZAJA => 'Catazajá',
            self::CINTALAPA => 'Cintalapa',
            self::COAPILLA => 'Coapilla',
            self::COMITAN_DE_DOMINGUEZ => 'Comitán de Domínguez',
            self::LA_CONCORDIA => 'La Concordia',
            
            // ... More municipalities would be added here
            default => throw new InvalidArgumentException("Unknown municipality with value {$this->value}"),
        };
    }

    /**
     * Get the state ID for this municipality.
     */
    public function estadoId(): int
    {
        return match(true) {
            $this->value >= 1 && $this->value <= 11 => EstadoEnum::AGUASCALIENTES->value,
            $this->value >= 12 && $this->value <= 16 => EstadoEnum::BAJA_CALIFORNIA->value,
            $this->value >= 17 && $this->value <= 21 => EstadoEnum::BAJA_CALIFORNIA_SUR->value,
            $this->value >= 22 && $this->value <= 32 => EstadoEnum::CAMPECHE->value,
            $this->value >= 33 && $this->value <= 70 => EstadoEnum::COAHUILA->value,
            $this->value >= 71 && $this->value <= 80 => EstadoEnum::COLIMA->value,
            $this->value >= 81 && $this->value <= 100 => EstadoEnum::CHIAPAS->value,
            // ... More ranges would be added here
            default => throw new InvalidArgumentException("Unknown state for municipality with value {$this->value}"),
        };
    }

    /**
     * Get the state enum for this municipality.
     */
    public function estado(): EstadoEnum
    {
        return EstadoEnum::from($this->estadoId());
    }

    /**
     * Get all municipalities as an array for select options.
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'nombre' => $case->nombre(),
            'estado_id' => $case->estadoId(),
        ], self::cases());
    }

    /**
     * Get all municipalities for a specific state.
     */
    public static function forEstado(EstadoEnum $estado): array
    {
        return array_filter(
            self::toArray(),
            fn($municipio) => $municipio['estado_id'] === $estado->value
        );
    }
} 
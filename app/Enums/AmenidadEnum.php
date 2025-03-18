<?php

namespace App\Enums;

enum AmenidadEnum: int
{
    case WIFI_GRATUITO = 1;
    case AIRE_ACONDICIONADO = 2;
    case CALEFACCION = 3;
    case PISCINA = 4;
    case GIMNASIO = 5;
    case ESTACIONAMIENTO = 6;
    case DESAYUNO_INCLUIDO = 7;
    case RESTAURANTE_BAR = 8;
    case SERVICIO_DE_HABITACIONES = 9;
    case TELEVISION_POR_CABLE_SATELITE = 10;
    case CAFETERA_EN_LA_HABITACION = 11;
    case CAJA_FUERTE = 12;
    case SECADOR_DE_CABELLO = 13;
    case AMENIDADES_DE_BANO = 14;
    case LIMPIEZA_DIARIA_DE_HABITACION = 15;
    case TOALLAS_Y_SABANAS_DE_ALTA_CALIDAD = 16;
    case SERVICIO_DE_LAVANDERIA = 17;
    case CENTRO_DE_NEGOCIOS_ESPACIOS_DE_TRABAJO = 18;
    case SPA_O_SERVICIO_DE_MASAJES = 19;
    case SALON_DE_EVENTOS_O_SALAS_DE_REUNIONES = 20;
    case TRASLADO_AL_AEROPUERTO_SHUTTLE = 21;
    case JACUZZI = 22;
    case BICICLETAS_DISPONIBLES = 23;
    case BARBACOA_O_ZONA_DE_PARRILLAS = 24;
    case ACCESO_PARA_PERSONAS_CON_MOVILIDAD_REDUCIDA = 25;
    case ADMISION_DE_MASCOTAS = 26;
    case CHIMENEA_EN_LA_HABITACION = 27;
    case TERRAZA_O_BALCON_PRIVADO = 28;
    case SISTEMA_DE_SONIDO = 29;
    case MINIBAR = 30;
    case ALQUILER_DE_COCHES_O_TRANSPORTE = 31;
    case ACCESO_A_ACTIVIDADES_RECREATIVAS = 32;
    case TIENDA_O_BOUTIQUE = 33;
    case CUNA_O_CAMA_EXTRA_DISPONIBLE_BAJO_SOLICITUD = 34;
    case ESTACION_DE_CARGA_PARA_DISPOSITIVOS_ELECTRONICOS = 35;
    case SERVICIOS_DE_CONSERJERIA = 36;
    case CINE_O_ZONA_DE_ENTRETENIMIENTO = 37;
    case ACCESO_A_DEPORTES = 38;
    case WIFI_EN_AREAS_COMUNES = 39;
    case CAFETERIA = 40;

    public function nombre(): string
    {
        return match($this) {
            self::WIFI_GRATUITO => 'Wifi gratuito',
            self::AIRE_ACONDICIONADO => 'Aire acondicionado',
            self::CALEFACCION => 'Calefacción',
            self::PISCINA => 'Piscina',
            self::GIMNASIO => 'Gimnasio',
            self::ESTACIONAMIENTO => 'Estacionamiento',
            self::DESAYUNO_INCLUIDO => 'Desayuno incluido',
            self::RESTAURANTE_BAR => 'Restaurante / Bar',
            self::SERVICIO_DE_HABITACIONES => 'Servicio de habitaciones',
            self::TELEVISION_POR_CABLE_SATELITE => 'Televisión por cable / satélite',
            self::CAFETERA_EN_LA_HABITACION => 'Cafetera en la habitación',
            self::CAJA_FUERTE => 'Caja fuerte',
            self::SECADOR_DE_CABELLO => 'Secador de cabello',
            self::AMENIDADES_DE_BANO => 'Amenidades de baño',
            self::LIMPIEZA_DIARIA_DE_HABITACION => 'Limpieza diaria de habitación',
            self::TOALLAS_Y_SABANAS_DE_ALTA_CALIDAD => 'Toallas y sábanas de alta calidad',
            self::SERVICIO_DE_LAVANDERIA => 'Servicio de lavandería',
            self::CENTRO_DE_NEGOCIOS_ESPACIOS_DE_TRABAJO => 'Centro de negocios / Espacios de trabajo',
            self::SPA_O_SERVICIO_DE_MASAJES => 'Spa o servicio de masajes',
            self::SALON_DE_EVENTOS_O_SALAS_DE_REUNIONES => 'Salón de eventos o salas de reuniones',
            self::TRASLADO_AL_AEROPUERTO_SHUTTLE => 'Traslado al aeropuerto (Shuttle)',
            self::JACUZZI => 'Jacuzzi',
            self::BICICLETAS_DISPONIBLES => 'Bicicletas disponibles',
            self::BARBACOA_O_ZONA_DE_PARRILLAS => 'Barbacoa o zona de parrillas',
            self::ACCESO_PARA_PERSONAS_CON_MOVILIDAD_REDUCIDA => 'Acceso para personas con movilidad reducida',
            self::ADMISION_DE_MASCOTAS => 'Admisión de mascotas',
            self::CHIMENEA_EN_LA_HABITACION => 'Chimenea en la habitación',
            self::TERRAZA_O_BALCON_PRIVADO => 'Terraza o balcón privado',
            self::SISTEMA_DE_SONIDO => 'Sistema de sonido',
            self::MINIBAR => 'Minibar',
            self::ALQUILER_DE_COCHES_O_TRANSPORTE => 'Alquiler de coches o transporte',
            self::ACCESO_A_ACTIVIDADES_RECREATIVAS => 'Acceso a actividades recreativas',
            self::TIENDA_O_BOUTIQUE => 'Tienda o boutique',
            self::CUNA_O_CAMA_EXTRA_DISPONIBLE_BAJO_SOLICITUD => 'Cuna o cama extra disponible bajo solicitud',
            self::ESTACION_DE_CARGA_PARA_DISPOSITIVOS_ELECTRONICOS => 'Estación de carga para dispositivos electrónicos',
            self::SERVICIOS_DE_CONSERJERIA => 'Servicios de conserjería',
            self::CINE_O_ZONA_DE_ENTRETENIMIENTO => 'Cine o zona de entretenimiento',
            self::ACCESO_A_DEPORTES => 'Acceso a deportes',
            self::WIFI_EN_AREAS_COMUNES => 'Wifi en áreas comunes',
            self::CAFETERIA => 'Cafetería',
        };
    }

    public function descripcion(): string
    {
        return match($this) {
            self::WIFI_GRATUITO => 'Conexion a internet de alta velocidad disponible sin costo adicional en las habitaciones y/o areas comunes del hospedaje.',
            self::AIRE_ACONDICIONADO => 'Sistema que permite controlar la temperatura del ambiente dentro de las habitaciones, garantizando un espacio comodo durante el verano o climas calidos.',
            self::CALEFACCION => 'Sistema que proporciona calor en las habitaciones o areas comunes, ideal para climas frios.',
            self::PISCINA => 'Area de agua para nadar, disponible en el hospedaje. Puede ser cubierta (interior) o al aire libre (exterior), ideal para relajarse o ejercitarse.',
            self::GIMNASIO => 'Espacio equipado con maquinas y equipo de ejercicio para mantener la actividad fisica durante la estancia.',
            self::ESTACIONAMIENTO => 'Espacios disponibles para aparcar vehiculos dentro o cerca del hospedaje. Puede ser gratuito o tener un costo adicional, dependiendo de la politica del lugar.',
            self::DESAYUNO_INCLUIDO => 'Servicio que ofrece una comida matutina dentro del hospedaje sin costo adicional para los huespedes, que suele incluir opciones como cafe, pan, frutas, entre otros.',
            self::RESTAURANTE_BAR => 'Un lugar dentro del hospedaje donde los huespedes pueden disfrutar de comidas, bebidas o cocteles sin tener que salir.',
            self::SERVICIO_DE_HABITACIONES => 'Posibilidad de solicitar comida, bebidas o productos a la habitacion sin tener que ir al restaurante o areas comunes.',
            self::TELEVISION_POR_CABLE_SATELITE => 'Television en la habitacion con acceso a canales adicionales mediante cable o satelite, para ofrecer mas opciones de entretenimiento.',
            self::CAFETERA_EN_LA_HABITACION => 'Aparato que permite preparar cafe, te u otras bebidas calientes directamente en la habitacion para mayor comodidad de los huespedes.',
            self::CAJA_FUERTE => 'Un pequeño espacio seguro dentro de la habitacion donde los huespedes pueden guardar objetos de valor como dinero, joyas o documentos importantes.',
            self::SECADOR_DE_CABELLO => 'Dispositivo disponible en las habitaciones o bajo solicitud para secar el cabello rapidamente despues de la ducha.',
            self::AMENIDADES_DE_BANO => 'Productos de higiene personal (como jabon, champu, acondicionador, crema corporal) disponibles en el bano para uso de los huespedes.',
            self::LIMPIEZA_DIARIA_DE_HABITACION => 'Servicio que asegura que la habitacion se mantenga limpia durante la estancia del huesped, con cambio de sabanas, toallas y reposicion de articulos.',
            self::TOALLAS_Y_SABANAS_DE_ALTA_CALIDAD => 'Ropa de cama y bano de materiales suaves y confortables, que ofrecen una experiencia de descanso mas placentera.',
            self::SERVICIO_DE_LAVANDERIA => 'Opcion para que los huespedes puedan lavar su ropa durante su estancia, generalmente con un costo adicional.',
            self::CENTRO_DE_NEGOCIOS_ESPACIOS_DE_TRABAJO => 'Zona equipada con computadoras, impresoras y otras herramientas para los huespedes que necesiten trabajar mientras estan fuera de la oficina.',
            self::SPA_O_SERVICIO_DE_MASAJES => 'Area o servicio que ofrece tratamientos de relajacion, como masajes, saunas o banos de vapor, para descansar y rejuvenecer.',
            self::SALON_DE_EVENTOS_O_SALAS_DE_REUNIONES => 'Espacios reservados para reuniones de trabajo, conferencias o eventos sociales, con equipos como proyectores, microfonos y pantallas.',
            self::TRASLADO_AL_AEROPUERTO_SHUTTLE => 'Servicio de transporte proporcionado por el hospedaje para llevar a los huespedes desde y hacia el aeropuerto, a menudo por una tarifa adicional.',
            self::JACUZZI => 'Banera de hidromasaje donde los huespedes pueden relajarse con agua caliente y burbujas, disponible en areas comunes o dentro de algunas habitaciones.',
            self::BICICLETAS_DISPONIBLES => 'Servicio que ofrece bicicletas para que los huespedes puedan recorrer los alrededores del hospedaje de forma ecologica y recreativa.',
            self::BARBACOA_O_ZONA_DE_PARRILLAS => 'Area al aire libre donde los huespedes pueden cocinar alimentos a la parrilla, ideal para reuniones sociales o eventos informales.',
            self::ACCESO_PARA_PERSONAS_CON_MOVILIDAD_REDUCIDA => 'Instalaciones adaptadas con rampas, ascensores y habitaciones especiales para garantizar la comodidad y seguridad de los huespedes con discapacidades.',
            self::ADMISION_DE_MASCOTAS => 'Politica que permite que los huespedes traigan a sus animales de compania durante su estancia, a menudo con un costo adicional o requisitos especificos.',
            self::CHIMENEA_EN_LA_HABITACION => 'Elemento decorativo o funcional en algunas habitaciones que permite a los huespedes disfrutar de un ambiente calido y acogedor, especialmente en climas frios.',
            self::TERRAZA_O_BALCON_PRIVADO => 'Espacio exterior privado en la habitacion, que ofrece vistas al entorno y un area para relajarse al aire libre.',
            self::SISTEMA_DE_SONIDO => 'Dispositivo que permite a los huespedes reproducir su musica desde sus telefonos u otros dispositivos electronicos a traves de conexion inalambrica.',
            self::MINIBAR => 'Pequena nevera dentro de la habitacion con una seleccion de bebidas y snacks, generalmente disponible por un costo adicional.',
            self::ALQUILER_DE_COCHES_O_TRANSPORTE => 'Servicio que permite a los huespedes alquilar vehiculos, motos u otros medios de transporte durante su estancia.',
            self::ACCESO_A_ACTIVIDADES_RECREATIVAS => 'Ofrecimiento de actividades al aire libre o deportes para los huespedes, como caminatas, kayak, surf, entre otros.',
            self::TIENDA_O_BOUTIQUE => 'Espacio de compras donde los huespedes pueden adquirir productos como recuerdos, ropa, cosmeticos o alimentos sin salir del hospedaje.',
            self::CUNA_O_CAMA_EXTRA_DISPONIBLE_BAJO_SOLICITUD => 'Opcion para que los huespedes pidan una cuna o cama adicional para ninos o personas adicionales en la habitacion.',
            self::ESTACION_DE_CARGA_PARA_DISPOSITIVOS_ELECTRONICOS => 'Area o puertos especificos para cargar telefonos moviles, laptops y otros dispositivos electronicos dentro de las habitaciones o areas comunes.',
            self::SERVICIOS_DE_CONSERJERIA => 'Asistencia personalizada para reservas de restaurantes, actividades turísticas, transporte, entre otros, para facilitar la estancia de los huespedes.',
            self::CINE_O_ZONA_DE_ENTRETENIMIENTO => 'Espacio dentro del hospedaje donde se proyectan peliculas o se realizan actividades recreativas como juegos o espectaculos en vivo.',
            self::ACCESO_A_DEPORTES => 'Instalaciones dentro del hospedaje que permiten a los huespedes practicar deportes como tenis, golf, baloncesto, entre otros.',
            self::WIFI_EN_AREAS_COMUNES => 'Conexion a internet gratuita en las areas comunes del hospedaje, como el lobby, restaurante o terraza, para que los huespedes puedan acceder facilmente a internet.',
            self::CAFETERIA => 'Espacio donde los huespedes pueden comprar bebidas, bocadillos o comidas ligeras en cualquier momento del dia o la noche.',
        };
    }

    /**
     * Get all amenities as an array for select options.
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

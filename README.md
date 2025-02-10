# Metabuscador de Destinos y Lugares Turísticos

### Powered by Laravel
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Bienvenida

¡Hola! Este es el repositorio del proyecto Metabuscador de Destinos y Tugares
turísticos (MetabuscadorDLT).

Este proyecto tiene como objetivo brindar una plataforma sencilla y fácil de
usar, la cual permita organizar planes de viaje a diferentes destinos,
ofreciendo ofertas, recomendaciones y sugerencias de hospedajes, lugares
turísticos para visitar, etc. Además de proveer indicaciones de transporte
mediante mapas interactivos.

## Inicialización del proyecto en entorno local

### Requisitos

Requisitos según la guía de instalación oficial de [Laravel](https://laravel.com/docs/11.x/installation).

- Instalar [php](https://www.php.net/).
- Instalar [composer](https://getcomposer.org/)
- Instalar [Node y NPM](https://nodejs.org/)

**Nota**: Es necesario habilitar las extensiones siguientes de php.
- **iconv**
- **pdo\_mysql**
- **zip**

---

Tener instalado **mariadb** con una base de datos vacia y un usuario con permisos sobre dicha base de datos.

**Nota**: Esto último solo será mientras conseguimos hosting para tener una base de datos remota para desarrollo.

### Configurar entorno local

Habiendo clonado el repositorio y cambiado al directorio donde se encuentra, es
necesario instalar los paquetes requeridos por el proyecto. Para ello se usan
los comandos:

```sh
composer install
npm install && npm run build
```

Es necesario establecer la estructura de la DB mediante el uso de migraciones de
Laravel. Solo se requiere ejecutar este comando al clonar el proyecto, o al crear nuevas migraciones.

```sh
php artisan migrate
```

Finalmente queda levantar el servidor.

```sh
composer run dev
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

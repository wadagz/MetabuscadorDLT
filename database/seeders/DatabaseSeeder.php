<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DestinoSeeder::class,
            PropietarioSeeder::class,
            DireccionesHotelesSeeder::class,
            AmenidadSeeder::class,
            HospedajeSeeder::class,
            PreferenciaSeeder::class,
            DireccionesActividadesSeeder::class,
            ActividadSeeder::class,
            HorarioRecurrenteSeeder::class,
            HorarioEventualSeeder::class,
            AmenidadHospedajeSeeder::class,
            EmpresaTransporteSeeder::class,
            RutaTransporteSeeder::class,
            ResenaTransporteSeeder::class,
        ]);
    }
}

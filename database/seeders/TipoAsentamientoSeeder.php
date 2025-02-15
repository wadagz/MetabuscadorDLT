<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAsentamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_asentamiento')->insert([
            [ 'id' => 9, 'descripcion' => 'Colonia'],
            [ 'id' => 28, 'descripcion' => 'Pueblo'],
            [ 'id' => 2, 'descripcion' => 'Barrio'],
            [ 'id' => 17, 'descripcion' => 'Equipamiento'],
            [ 'id' => 4, 'descripcion' => 'Campamento'],
            [ 'id' => 1, 'descripcion' => 'Aeropuerto'],
            [ 'id' => 21, 'descripcion' => 'Fraccionamiento'],
            [ 'id' => 10, 'descripcion' => 'Condominio'],
            [ 'id' => 31, 'descripcion' => 'Unidad habitacional'],
            [ 'id' => 33, 'descripcion' => 'Zona comercial'],
            [ 'id' => 48, 'descripcion' => 'Rancho'],
            [ 'id' => 29, 'descripcion' => 'Ranchería'],
            [ 'id' => 37, 'descripcion' => 'Zona industrial'],
            [ 'id' => 23, 'descripcion' => 'Granja'],
            [ 'id' => 15, 'descripcion' => 'Ejido'],
            [ 'id' => 45, 'descripcion' => 'Paraje'],
            [ 'id' => 24, 'descripcion' => 'Hacienda'],
            [ 'id' => 12, 'descripcion' => 'Conjunto habitacional'],
            [ 'id' => 47, 'descripcion' => 'Zona militar'],
            [ 'id' => 34, 'descripcion' => 'Zona federal'],
            [ 'id' => 40, 'descripcion' => 'Puerto'],
            [ 'id' => 18, 'descripcion' => 'Exhacienda'],
            [ 'id' => 46, 'descripcion' => 'Zona naval'],
            [ 'id' => 20, 'descripcion' => 'Finca']
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados')->insert([
            [ 'id' => 9, 'nombre' => 'Ciudad de México', 'abreviatura' => 'AGU'],
            [ 'id' => 1, 'nombre' => 'Aguascalientes', 'abreviatura' => 'BCN'],
            [ 'id' => 2, 'nombre' => 'Baja California', 'abreviatura' => 'BCS'],
            [ 'id' => 3, 'nombre' => 'Baja California Sur', 'abreviatura' => 'CAM'],
            [ 'id' => 4, 'nombre' => 'Coahuila', 'abreviatura' => 'CHP'],
            [ 'id' => 5, 'nombre' => 'Coahuila de Zaragoza', 'abreviatura' => 'CHH'],
            [ 'id' => 6, 'nombre' => 'Colima', 'abreviatura' => 'COA'],
            [ 'id' => 7, 'nombre' => 'Chiapas', 'abreviatura' => 'COL'],
            [ 'id' => 8, 'nombre' => 'Chihuahua', 'abreviatura' => 'CMX'],
            [ 'id' => 10, 'nombre' => 'Durango', 'abreviatura' => 'DUR'],
            [ 'id' => 11, 'nombre' => 'Guanajuato', 'abreviatura' => 'GUA'],
            [ 'id' => 12, 'nombre' => 'Guerrero', 'abreviatura' => 'GRO'],
            [ 'id' => 13, 'nombre' => 'Hidalgo', 'abreviatura' => 'HID'],
            [ 'id' => 14, 'nombre' => 'Jalisco', 'abreviatura' => 'JAL'],
            [ 'id' => 15, 'nombre' => 'México', 'abreviatura' => 'MEX'],
            [ 'id' => 16, 'nombre' => 'Michoacán', 'abreviatura' => 'MIC'],
            [ 'id' => 17, 'nombre' => 'Morelos', 'abreviatura' => 'MOR'],
            [ 'id' => 18, 'nombre' => 'Nayarit', 'abreviatura' => 'NAY'],
            [ 'id' => 19, 'nombre' => 'Nuevo León', 'abreviatura' => 'NLE'],
            [ 'id' => 20, 'nombre' => 'Oaxaca', 'abreviatura' => 'OAX'],
            [ 'id' => 21, 'nombre' => 'Puebla', 'abreviatura' => 'PUE'],
            [ 'id' => 22, 'nombre' => 'Querétaro', 'abreviatura' => 'QUE'],
            [ 'id' => 23, 'nombre' => 'Quintana Roo', 'abreviatura' => 'ROO'],
            [ 'id' => 24, 'nombre' => 'San Luis Potosí', 'abreviatura' => 'SLP'],
            [ 'id' => 25, 'nombre' => 'Sinaloa', 'abreviatura' => 'SIN'],
            [ 'id' => 26, 'nombre' => 'Sonora', 'abreviatura' => 'SON'],
            [ 'id' => 27, 'nombre' => 'Tabasco', 'abreviatura' => 'TAB'],
            [ 'id' => 28, 'nombre' => 'Tamaulipas', 'abreviatura' => 'TAM'],
            [ 'id' => 29, 'nombre' => 'Tlaxcala', 'abreviatura' => 'TLA'],
            [ 'id' => 30, 'nombre' => 'Veracruz', 'abreviatura' => 'VER'],
            [ 'id' => 31, 'nombre' => 'Yucatán', 'abreviatura' => 'YUC'],
            [ 'id' => 32, 'nombre' => 'Zacatecas', 'abreviatura' => 'ZAC'],
        ]);
    }
}

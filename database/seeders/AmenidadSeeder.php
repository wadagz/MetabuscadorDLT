<?php

namespace Database\Seeders;

use App\Enums\AmenidadEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenidades = AmenidadEnum::toArray();
        foreach($amenidades as $amenidad)
        {
            DB::table('amenidades')->insert([
                'nombre' => $amenidad['nombre'],
                'descripcion' => $amenidad['descripcion'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Enums\TipoVialidadEnum;
use App\Enums\TipoAsentamientoEnum;

class HospedajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('database/seeds/data/hospedajes_hoteles.csv');
        $handle = fopen($csvFile, 'r');

        $rowCount = 0;

        while (($row = fgetcsv($handle, 1000, ',', escape: "")) !== FALSE) {
            if ($rowCount === 0) {
                // Skip the first row if it's the header row
                $rowCount++;
                continue;
            }

            // Get random enum values
            $tipoVialidadCases = TipoVialidadEnum::cases();
            $tipoAsentamientoCases = TipoAsentamientoEnum::cases();
            
            $tipoVialidadRandom = $tipoVialidadCases[array_rand($tipoVialidadCases)];
            $tipoAsentamientoRandom = $tipoAsentamientoCases[array_rand($tipoAsentamientoCases)];

            // First, create a direccion
            $now = Carbon::now();
            $direccionId = DB::table('direcciones')->insertGetId([
                'nombre' => fake()->paragraph(2),
                'latitud' => $this->randomLatitude(),
                'longitud' => $this->randomLongitude(),
                'id_tipo_vialidad' => $tipoVialidadRandom->value,
                'id_asentamiento' => $tipoAsentamientoRandom->value,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Then create the hospedaje with the direccion_id
            DB::table('hospedajes')->insert([
                'nombre' => $row[0],
                'precio' => fake()->numberBetween(1000, 20000),
                'url' => 'https://google.com',
                'propietario_id' => $row[9],
                'destino_id' => $row[10],
                'tipo_hospedaje' => 1,
                'direccion_id' => $direccionId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $rowCount++;
        }

        fclose($handle);
    }

    /**
     * Generate a random latitude between -90 and 90 with 8 decimal places
     */
    private function randomLatitude(): float
    {
        return round(mt_rand(-899999999, 899999999) / 10000000, 8);
    }

    /**
     * Generate a random longitude between -180 and 180 with 8 decimal places
     */
    private function randomLongitude(): float
    {
        return round(mt_rand(-1799999999, 1799999999) / 10000000, 8);
    }
}
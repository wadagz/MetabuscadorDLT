<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\TipoVialidadEnum;
use App\Enums\TipoAsentamientoEnum;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DireccionesHotelesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('database/seeds/data/direcciones_hoteles.csv');
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

            $now = Carbon::now();
            DB::table('direcciones')->insert([
                'nombre' => $row[0],
                'latitud' => $row[5],
                'longitud' => $row[6],
                'id_tipo_vialidad' => $tipoVialidadRandom->value,
                'id_asentamiento' => $tipoAsentamientoRandom->value,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $rowCount++;
        }

        fclose($handle);
    }
}

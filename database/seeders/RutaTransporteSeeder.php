<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutaTransporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('database/seeds/data/rutas_entre_destinos.csv');  // Adjust the path as needed
        $handle = fopen($csvFile, 'r');

        $batchSize = 1000; // Process 10,000 records at a time to avoid memory issues
        $data = [];
        $rowCount = 0;

        while (($row = fgetcsv($handle, 1000, ',', escape: "")) !== FALSE) {
            if ($rowCount === 0) {
                // Skip the first row if it's the header row
                $rowCount++;
                continue;
            }

            // Process each row as needed (mapping CSV data to database columns)
            $data[] = [
                'id' => $row[10],
                'destino_origen_id' => $row[0],
                'destino_target_id' => $row[1],
                'empresa_transporte_id' => $row[2],
                'destino_origen_nombre' => $row[3],
                'destino_target_nombre' => $row[4],
                'tipo' => $row[5],
                'distancia_km' => $row[7],
                'duracion_min' => $row[8],
                'precio' => $row[9],
            ];

            // Insert in batches
            if (count($data) >= $batchSize) {
                DB::table('rutas_transporte')->insert($data);
                $data = [];  // Reset data array for next batch
            }
        }

        // Insert any remaining records
        if (count($data) > 0) {
            DB::table('rutas_transporte')->insert($data);
        }

        fclose($handle);
    }
}

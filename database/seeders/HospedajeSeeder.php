<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospedajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('database/seeds/data/hospedajes_hoteles.csv');  // Adjust the path as needed
        $handle = fopen($csvFile, 'r');

        $batchSize = 1000; // Process 1,000 records at a time to avoid memory issues
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
                'nombre' => $row[0],
                'precio' => fake()->numberBetween(1000, 20000),
                'url' => 'https://google.com',
                'propietario_id' => $row[9],
                'destino_id' => $row[10],
                'tipo_hospedaje' => 1,
            ];

            // Insert in batches
            if (count($data) >= $batchSize) {
                DB::table('hospedajes')->insert($data);
                $data = [];  // Reset data array for next batch
            }
        }

        // Insert any remaining records
        if (count($data) > 0) {
            DB::table('hospedajes')->insert($data);
        }

        fclose($handle);
    }
}

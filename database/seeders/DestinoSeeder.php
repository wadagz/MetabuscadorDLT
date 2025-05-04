<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('database/seeds/data/destinos.csv');  // Adjust the path as needed
        $handle = fopen($csvFile, 'r');

        $batchSize = 10000; // Process 10,000 records at a time to avoid memory issues
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
                'municipio' => $row[4],
                'estado' => $row[5],
                'latitud' => $row[7],
                'longitud' => $row[8],
                'descripcion' => fake()->paragraph(5),
                'precio_promedio' => fake()->randomFloat(2, 500, 20000),
                'img_path' => $row[17],
            ];

            // Insert in batches
            if (count($data) >= $batchSize) {
                DB::table('destinos')->insert($data);
                $data = [];  // Reset data array for next batch
            }
        }

        // Insert any remaining records
        if (count($data) > 0) {
            DB::table('destinos')->insert($data);
        }

        fclose($handle);
    }
}

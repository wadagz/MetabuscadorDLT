<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsentamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = storage_path('app/private/asentamientos.csv');  // Adjust the path as needed
        $handle = fopen($csvFile, 'r');

        $batchSize = 1000; // Process 1000 records at a time to avoid memory issues
        $data = [];
        $rowCount = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if ($rowCount === 0) {
                // Skip the first row if it's the header row
                $rowCount++;
                continue;
            }

            // Process each row as needed (mapping CSV data to database columns)
            $data[] = [
                'id_codigo_postal' => $row[0],
                'nombre' => $row[1],
                'id_tipo_asentamiento' => $row[2],
                'id_estado' => $row[3],
                'id_municipio' => $row[4],
            ];

            // Insert in batches
            if (count($data) >= $batchSize) {
                DB::table('asentamientos')->insert($data);
                $data = [];  // Reset data array for next batch
            }
        }

        // Insert any remaining records
        if (count($data) > 0) {
            DB::table('asentamientos')->insert($data);
        }

        fclose($handle);
    }
}

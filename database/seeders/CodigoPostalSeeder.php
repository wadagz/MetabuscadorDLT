<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodigoPostalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('database/seeds/data/codigos_postales.csv');  // Adjust the path as needed
        $handle = fopen($csvFile, 'r');

        $batchSize = 10000; // Process 1000 records at a time to avoid memory issues
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
                'id' => $row[0],
                'id_municipio' => $row[1],
            ];

            // Insert in batches
            if (count($data) >= $batchSize) {
                DB::table('codigos_postales')->insert($data);
                $data = [];  // Reset data array for next batch
            }
        }

        // Insert any remaining records
        if (count($data) > 0) {
            DB::table('codigos_postales')->insert($data);
        }

        fclose($handle);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DestinoSeeder extends Seeder
{
    /**
     * Arreglo de imágenes usadas como placeholders para destinos.
     */
    protected $imgPlaceholders = [
        'https://media.traveler.es/photos/613768b26936668f30c3e855/master/w_1600%2Cc_limit/159073.jpg',
        'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/Skyline_de_Monterrey.jpg/750px-Skyline_de_Monterrey.jpg',
        'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
        'https://www.interactiveaquariumcancun.com/hubfs/shutterstock_1790369900.jpg_554688468.jpg',
        'https://www.entornoturistico.com/wp-content/uploads/2023/07/Monumento-de-la-Independencia-en-la-Ciudad-de-Mexico-desde-las-alturas.jpg',
        'https://image-tc.galaxy.tf/wijpeg-30uiabg4905tkd4fpky4ljrq1/mazatlan-1920x1080_standard.jpg?crop=240%2C0%2C1440%2C1080',
        'https://a.travel-assets.com/findyours-php/viewfinder/images/res70/228000/228069-Guerrero.jpg',
        'https://cdn.britannica.com/00/188200-050-1995DFEE/view-city-Guanajuato-foreground-Mexico-basilica.jpg',
        'https://a.travel-assets.com/findyours-php/viewfinder/images/res70/228000/228664-Zocalo-Square.jpg',
    ];

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
                'img_path' => fake()->randomElement($this->imgPlaceholders),
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HospedajeSeeder extends Seeder
{
    protected $images = [
      'https://i0.wp.com/foodandpleasure.com/wp-content/uploads/2020/10/65345792-h1-facb_angular_pool_view_300dpi.jpg?fit=2800%2C1867&ssl=1',
      'https://image-tc.galaxy.tf/wijpeg-dvi5rtm812e96dah51ls0h5dp/fachada-desde-alberca_standard.jpg?crop=100%2C0%2C1600%2C1200',
      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTaCs7wq35j-aNLg7vLa3HazL74N0fUaVTdLA&s',
      'https://cdn.forbes.com.mx/2020/07/hoteles-Grand-Velas-Resorts-e1596047698604.jpg',
      'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1c/d2/24/42/playa-los-arcos-hotel.jpg?w=1200&h=-1&s=1',
      'https://www.interactiveaquariumcancun.com/hubfs/crown%20paradise%20club%20cancun.jpg',
      'https://traveler.marriott.com/es/wp-content/uploads/sites/2/2024/07/The_Westin_Reserva_Conchal_-_Edgardo_Contreras-1.jpg',
      'https://gdconsejoscancun.b-cdn.net/wp-content/uploads/2019/11/hotel-tijuana.jpeg',
      'https://www.momondo.mx/himg/42/85/7f/expediav2-10076-c8fdf6-526133.jpg',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('database/seeds/data/hoteles.csv');
        $handle = fopen($csvFile, 'r');

        $rowCount = 0;

        while (($row = fgetcsv($handle, 1000, ',', escape: "")) !== FALSE) {
            if ($rowCount === 0) {
                // Skip the first row if it's the header row
                $rowCount++;
                continue;
            }

            // Then create the hospedaje with the direccion_id
            $now = Carbon::now();
            DB::table('hospedajes')->insert([
                'direccion_id' => $rowCount,
                'propietario_id' => $rowCount,
                'destino_id' => $row[2],
                'nombre' => $row[0],
                'precio' => $row[1],
                'url' => 'https://google.com',
                'tipo_hospedaje' => 1,
                'descripcion' => fake()->text(200),
                'img_path' => $this->images[array_rand($this->images)],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $rowCount++;
        }

        fclose($handle);
    }
}

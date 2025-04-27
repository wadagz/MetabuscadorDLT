<?php

namespace Database\Seeders;

use App\Models\Hospedaje;
use App\Models\ResenaHospedaje;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResenaHospedajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hospedajes = Hospedaje::all();
        $users = User::pluck('id');

        $hospedajes->each(function ($hospedaje) use ($users) {
            $cantResenas = random_int(5, 20);
            ResenaHospedaje::factory()->count($cantResenas)->create([
                'hospedaje_id' => $hospedaje->id,
                'user_id' => function () use ($users) {
                    return $users->random();
                },
            ]);
        });
    }
}

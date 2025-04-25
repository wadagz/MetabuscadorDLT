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
        $users = User::all();
        $hospedajes = Hospedaje::pluck('id');

        $users->each(function ($user) use ($hospedajes) {
            $cantResenas = random_int(0, 10);
            ResenaHospedaje::factory()->count($cantResenas)->create([
                'user_id' => $user->id,
                'hospedaje_id' => function () use ($hospedajes) {
                    return $hospedajes->random();
                },
            ]);
        });
    }
}

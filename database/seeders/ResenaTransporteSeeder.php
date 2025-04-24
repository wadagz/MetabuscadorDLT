<?php

namespace Database\Seeders;

use App\Models\ResenaTransporte;
use App\Models\RutaTransporte;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResenaTransporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $rutasTransporte = RutaTransporte::pluck('id');

        $users->each(function ($user) use ($rutasTransporte) {
            $cantResenas = random_int(0, 10);
            ResenaTransporte::factory()->count($cantResenas)->create([
                'user_id' => $user->id,
                'ruta_transporte_id' => function () use ($rutasTransporte) {
                    return $rutasTransporte->random();
                },
            ]);
        });

    }
}

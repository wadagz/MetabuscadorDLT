<?php

namespace Database\Seeders;

use App\Enums\PreferenciaEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preferencias = PreferenciaEnum::toArray();
        for($i = 0; $i < count($preferencias); $i++)
        {
            DB::table('preferencias')->insert(['descripcion' => $preferencias[$i]['descripcion']]);
        }
    }
}

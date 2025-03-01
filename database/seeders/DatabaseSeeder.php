<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Use 'password' as default password for the user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            EstadoSeeder::class,
            MunicipioSeeder::class,
            TipoAsentamientoSeeder::class,
            AsentamientoSeeder::class,
            TipoVialidadSeeder::class,
        ]);
    }
}

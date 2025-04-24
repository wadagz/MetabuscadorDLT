<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResenaTransporte>
 */
class ResenaTransporteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'ruta_transporte_id' => 1,
            'calificacion' => fake()->numberBetween(0, 5),
            'comentario' => fake()->paragraph(5),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResenaHospedaje>
 */
class ResenaHospedajeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comentario' => fake()->paragraph(5),
            'calificacion' => fake()->randomElement([1,2,3,4,5]),
            'user_id' => 1,
            'hospedaje_id' => 1,
            'fecha' => fake()->dateTimeBetween('-5 years', 'now'),
        ];
    }
}

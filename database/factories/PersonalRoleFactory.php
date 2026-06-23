<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class PersonalRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ficha_empleado' => fake()->randomNumber(5, true),
            'rol_id' => fake()->randomNumber(),
            'fecha_asignado' => now(),
            'estatus' => true
        ];
    }
}

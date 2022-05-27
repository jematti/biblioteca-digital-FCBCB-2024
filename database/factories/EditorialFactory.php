<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Editorial>
 */
class EditorialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre_editorial' => $this->faker->sentence(10),
            'direccion'=> $this->faker->sentence(20),
            'contacto'=> $this->faker->sentence(20)
        ];
    }
}

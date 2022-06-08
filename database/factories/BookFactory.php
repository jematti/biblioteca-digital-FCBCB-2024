<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(10),
            'edicion'=> $this->faker->sentence(10),
            'ubicacion'=> $this->faker->sentence(10),
            'numero_paginas'=> $this->faker->numberBetween($min = 1, $max = 1000) ,
            'fecha_publicacion'=> $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'idioma'=> $this->faker->sentence(10),
            'resumen'=> $this->faker->sentence(10),
            'imagen'=> $this->faker->uuid().'.jpg',
            'author_id'=> $this->faker->randomElement([1,2]),
            'editorial_id'=> $this->faker->randomElement([1,2]),
            'category_id'=> $this->faker->randomElement([1,2]),
        ];
    }
}

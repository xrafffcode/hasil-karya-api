<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TruckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strval($this->faker->unique()->randomNumber(5)),
            'name' => $this->faker->name,
            'capacity' => $this->faker->randomFloat(2, 1, 100),
            'is_active' => $this->faker->boolean,
        ];
    }
}

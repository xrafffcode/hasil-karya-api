<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HeavyVehicleFactory extends Factory
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
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'production_year' => $this->faker->year,
            'is_active' => $this->faker->boolean,
        ];
    }
}

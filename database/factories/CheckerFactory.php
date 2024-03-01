<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CheckerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strval($this->faker->unique()->randomNumber(8)),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'is_active' => $this->faker->boolean,
        ];
    }
}

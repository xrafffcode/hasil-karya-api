<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MaterialMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strval(Str::random(10)),
            'date' => $this->faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            'amount' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}

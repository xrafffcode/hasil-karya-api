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
            'observation_ratio_percentage' => $this->faker->randomFloat(2, 0.3, 1),
            'observation_ratio_number' => $this->faker->randomFloat(2, 0.3, 1),
            'solid_ratio' => $this->faker->randomFloat(4, 0.0, 1),
            'solid_volume_estimate' => $this->faker->randomFloat(2, 0.3, 1),
            'remarks' => $this->faker->text(),
        ];
    }
}

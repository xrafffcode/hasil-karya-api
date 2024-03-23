<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FuelLogErrorLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::random(10),
            'date' => strval($this->faker->dateTimeThisYear()->format('Y-m-d H:i:s')),
            'driver_id' => strval($this->faker->uuid),
            'truck_id' => strval($this->faker->uuid),
            'station_id' => strval($this->faker->uuid),
            'checker_id' => strval($this->faker->uuid),
            'truck_capacity' => strval($this->faker->numberBetween(5, 30)),
            'observation_ratio_percentage' => strval($this->faker->numberBetween(5, 30)),
            'solid_ratio' => strval($this->faker->randomFloat(2, 0.5, 1.2)),
            'remarks' => strval($this->faker->text),
            'error_log' => strval($this->faker->text),
        ];
    }
}

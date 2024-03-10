<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VehicleRentalRecordFactory extends Factory
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
            'start_date' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'rental_duration' => mt_rand(1, 90),
            'rental_cost' => $this->faker->randomFloat(2, 10000000, 20000000),
            'is_paid' => $this->faker->boolean,
            'remarks' => $this->faker->text,
        ];
    }
}

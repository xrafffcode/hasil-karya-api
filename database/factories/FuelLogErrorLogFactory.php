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
            'truck_id' => strval($this->faker->uuid),
            'heavy_vehicle_id' => strval($this->faker->uuid),
            'driver_id' => strval($this->faker->uuid),
            'station_id' => strval($this->faker->uuid),
            'gas_operator_id' => strval($this->faker->uuid),
            'fuel_type' => strval($this->faker->randomElement(['diesel', 'pertamax', 'pertalite', 'pertamax turbo'])),
            'volume' => strval($this->faker->randomFloat(2, 1, 1000)),
            'odometer' => strval($this->faker->randomFloat(2, 1, 1000)),
            'hourmeter' => strval($this->faker->randomFloat(2, 1, 1000)),
            'remarks' => $this->faker->text(),
            'error_log' => $this->faker->text(),
        ];
    }
}

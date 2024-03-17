<?php

namespace Database\Factories;

use App\Repositories\HeavyVehicleRepository;
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
        $heavyVehicleRepository = new HeavyVehicleRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $heavyVehicleRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $heavyVehicleRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'production_year' => $this->faker->year,
            'is_active' => $this->faker->boolean,
        ];
    }
}

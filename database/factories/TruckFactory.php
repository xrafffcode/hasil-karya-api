<?php

namespace Database\Factories;

use App\Repositories\TruckRepository;
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
        $truckRepository = new TruckRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $truckRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $truckRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'capacity' => $this->faker->randomFloat(2, 1, 100),
            'production_year' => $this->faker->year,
            'is_active' => $this->faker->boolean,
        ];
    }
}

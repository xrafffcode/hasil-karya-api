<?php

namespace Database\Factories;

use App\Repositories\MaterialMovementRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $materialMovementRepository = new MaterialMovementRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $materialMovementRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $materialMovementRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'date' => $this->faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            'truck_capacity' => random_int(5, 20),
            'observation_ratio_percentage' => $this->faker->randomFloat(2, 0.3, 1),
            'observation_ratio_number' => $this->faker->randomFloat(2, 0.3, 1),
            'solid_ratio' => $this->faker->randomFloat(4, 0.0, 1),
            'solid_volume_estimate' => $this->faker->randomFloat(2, 0.3, 1),
            'remarks' => $this->faker->text(),
        ];
    }
}

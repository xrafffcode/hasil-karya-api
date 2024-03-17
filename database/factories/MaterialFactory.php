<?php

namespace Database\Factories;

use App\Repositories\MaterialRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $materialRepository = new MaterialRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $materialRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $materialRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'name' => $this->faker->name,
        ];
    }
}

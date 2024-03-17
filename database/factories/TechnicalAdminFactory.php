<?php

namespace Database\Factories;

use App\Repositories\TechnicalAdminRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnicalAdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $technicalAdminRepository = new TechnicalAdminRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $technicalAdminRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $technicalAdminRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'name' => $this->faker->name,
            'is_active' => $this->faker->boolean,
        ];
    }

    public function withCredentials(): TechnicalAdminFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => $this->faker->unique()->safeEmail,
                'password' => 'password',
            ];
        });
    }
}

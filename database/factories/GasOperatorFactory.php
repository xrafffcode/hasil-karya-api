<?php

namespace Database\Factories;

use App\Repositories\GasOperatorRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class GasOperatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gasOperatorRepository = new GasOperatorRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $gasOperatorRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $gasOperatorRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'name' => $this->faker->name,
            'is_active' => $this->faker->boolean,
        ];
    }

    public function withCredentials(): GasOperatorFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => $this->faker->unique()->safeEmail,
                'password' => 'password',
            ];
        });
    }
}

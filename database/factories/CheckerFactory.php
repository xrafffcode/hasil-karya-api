<?php

namespace Database\Factories;

use App\Repositories\CheckerRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkerRepository = new CheckerRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $checkerRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $checkerRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'name' => $this->faker->name,
            'is_active' => $this->faker->boolean,
        ];
    }

    public function withCredentials(): CheckerFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => $this->faker->unique()->safeEmail,
                'password' => 'password',
            ];
        });
    }
}

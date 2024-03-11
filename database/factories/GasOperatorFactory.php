<?php

namespace Database\Factories;

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
        return [
            'code' => strval($this->faker->unique()->randomNumber(8)),
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

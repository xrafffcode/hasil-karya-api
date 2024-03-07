<?php

namespace Database\Factories;

use App\Enum\StationCategoryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = StationCategoryEnum::toArray();

        return [
            'code' => strval($this->faker->unique()->randomNumber(8)),
            'name' => $this->faker->name,
            'category' => $this->faker->randomElement($categories),
            'is_active' => $this->faker->boolean,
        ];
    }
}

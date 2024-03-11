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
            'province' => $this->faker->state,
            'regency' => $this->faker->city,
            'district' => $this->faker->streetName,
            'subdistrict' => $this->faker->streetName,
            'address' => $this->faker->address,
            'category' => $this->faker->randomElement($categories),
            'is_active' => $this->faker->boolean,
        ];
    }
}

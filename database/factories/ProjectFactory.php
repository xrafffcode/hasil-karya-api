<?php

namespace Database\Factories;

use App\Enum\ProjectStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = $this->faker->date();
        $end_date = $this->faker->dateTimeBetween($start_date, '+1 year')->format('Y-m-d');

        return [
            'code' => strval($this->faker->randomNumber(5)),
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'person_in_charge' => $this->faker->name,
            'amount' => $this->faker->randomFloat(2, 0, 1000000),
            'province' => $this->faker->state,
            'regency' => $this->faker->city,
            'district' => $this->faker->streetName,
            'subdistrict' => $this->faker->secondaryAddress,
            'status' => $this->faker->randomElement(ProjectStatusEnum::toArray()),
        ];
    }
}

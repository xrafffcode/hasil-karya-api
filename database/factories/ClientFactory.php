<?php

namespace Database\Factories;

use App\Repositories\ClientRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientRepository = new ClientRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $clientRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $clientRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'name' => $this->faker->name,
            'province' => $this->faker->state,
            'regency' => $this->faker->city,
            'district' => $this->faker->streetName,
            'subdistrict' => $this->faker->streetName,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }

    public function withoutAdministrativeUnit(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'province' => null,
                'regency' => null,
                'district' => null,
                'subdistrict' => null,
            ];
        });
    }
}

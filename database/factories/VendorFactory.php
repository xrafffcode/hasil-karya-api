<?php

namespace Database\Factories;

use App\Repositories\VendorRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vendorRepository = new VendorRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $vendorRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $vendorRepository->isUniqueCode($code));

        return [
            'code' => $code,
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'is_active' => $this->faker->boolean,
        ];
    }
}

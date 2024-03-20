<?php

namespace Database\Factories;

use App\Repositories\VehicleRentalRecordRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class VehicleRentalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicleRentalRecordRepository = new VehicleRentalRecordRepository();

        $code = '';
        $tryCount = 0;
        do {
            $code = $vehicleRentalRecordRepository->generateCode($tryCount);
            $tryCount++;
        } while (! $vehicleRentalRecordRepository->isUniqueCode($code));

        $randomFloat = $this->faker->randomFloat(0, 1000000, 30000000);
        $rentalCost = round($randomFloat / 100000) * 100000;

        return [
            'code' => $code,
            'start_date' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'rental_duration' => mt_rand(1, 90),
            'rental_cost' => $rentalCost,
            'is_paid' => $this->faker->boolean,
            'remarks' => $this->faker->text,
            'payment_proof_image' => UploadedFile::fake()->image('payment_proof_image.jpg'),
        ];
    }
}

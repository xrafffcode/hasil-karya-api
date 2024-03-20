<?php

namespace Database\Seeders;

use App\Models\HeavyVehicle;
use App\Models\Truck;
use App\Models\VehicleRentalRecord;
use Illuminate\Database\Seeder;

class VehicleRentalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countPaid = 5;
        for ($i = 0; $i < $countPaid; $i++) {
            $vehicleRentalRecord = VehicleRentalRecord::factory();

            if (mt_rand(0, 1) == 0) {
                $vehicleRentalRecord = $vehicleRentalRecord
                    ->for(Truck::inRandomOrder()->first());
            } else {
                $vehicleRentalRecord = $vehicleRentalRecord
                    ->for(HeavyVehicle::inRandomOrder()->first());
            }

            $vehicleRentalRecord->create([
                'is_paid' => true,
            ]);
        }

        $countUnpaid = 2;
        for ($i = 0; $i < $countUnpaid; $i++) {
            $vehicleRentalRecord = VehicleRentalRecord::factory();

            if (mt_rand(0, 1) == 0) {
                $vehicleRentalRecord = $vehicleRentalRecord
                    ->for(Truck::inRandomOrder()->first());
            } else {
                $vehicleRentalRecord = $vehicleRentalRecord
                    ->for(HeavyVehicle::inRandomOrder()->first());
            }

            $subDays = mt_rand(1, 30);
            $rentalDuration = $subDays + mt_rand(1, 30);
            $vehicleRentalRecord->create([
                'start_date' => now()->subDays(mt_rand(1, $subDays))->format('Y-m-d H:i:s'),
                'rental_duration' => $rentalDuration,
                'is_paid' => false,
            ]);
            $vehicleRentalRecord->create([
                'is_paid' => false,
            ]);
        }

        $countUnpaidAndOverdue = 3;
        for ($i = 0; $i < $countUnpaidAndOverdue; $i++) {
            $vehicleRentalRecord = VehicleRentalRecord::factory();

            if (mt_rand(0, 1) == 0) {
                $vehicleRentalRecord = $vehicleRentalRecord
                    ->for(Truck::inRandomOrder()->first());
            } else {
                $vehicleRentalRecord = $vehicleRentalRecord
                    ->for(HeavyVehicle::inRandomOrder()->first());
            }

            $subDays = mt_rand(1, 30);
            $rentalDuration = mt_rand(1, $subDays - 1);
            $vehicleRentalRecord->create([
                'start_date' => now()->subDays(mt_rand(1, $subDays))->format('Y-m-d H:i:s'),
                'rental_duration' => $rentalDuration,
                'is_paid' => false,
            ]);
        }
    }
}

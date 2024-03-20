<?php

namespace Database\Seeders;

use App\Models\Checker;
use App\Models\Driver;
use App\Models\MaterialMovement;
use App\Models\Station;
use App\Models\Truck;
use DateTime;
use Illuminate\Database\Seeder;

class MaterialMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 150; $i++) {
            $now = new DateTime();
            $now->modify('first day of January');
            $randomDays = rand(0, $now->format('z'));
            $now->modify("+$randomDays days");

            $driver = Driver::inRandomOrder()->first();
            $truck = Truck::inRandomOrder()->first();
            $station = Station::inRandomOrder()->first();
            $checker = Checker::inRandomOrder()->first();
            $date = now()->startOfYear()->addDays(rand(0, 360))->toDateTimeString();
            $truckCapacity = $truck->capacity;
            $observationRatioPercentage = rand(3, 10) / 10;
            $observationRatioNumber = $truckCapacity * $observationRatioPercentage;
            $solidRatio = 0;
            $solidVolumeEstimate = 0;

            MaterialMovement::factory()->create([
                'driver_id' => $driver->id,
                'truck_id' => $truck->id,
                'station_id' => $station->id,
                'checker_id' => $checker->id,
                'date' => $date,
                'truck_capacity' => $truckCapacity,
                'observation_ratio_percentage' => $observationRatioPercentage,
                'observation_ratio_number' => $observationRatioNumber,
                'solid_ratio' => $solidRatio,
                'solid_volume_estimate' => $solidVolumeEstimate,
                'remarks' => '',
            ]);
        }
    }
}

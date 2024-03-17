<?php

namespace Database\Seeders;

use App\Models\HeavyVehicle;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class HeavyVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heavyVehicles = [
            [
                'brand' => 'Caterpillar',
                'model' => 'D6T',
                'vendor_id' => Vendor::inRandomOrder()->first()->id,
                'is_active' => true,
            ],
            [
                'brand' => 'Komatsu',
                'model' => 'PC200-8',
                'vendor_id' => Vendor::inRandomOrder()->first()->id,
                'is_active' => true,
            ],
            [
                'brand' => 'Volvo',
                'model' => 'EC220DL',
                'vendor_id' => Vendor::inRandomOrder()->first()->id,
                'is_active' => true,
            ],
        ];

        foreach ($heavyVehicles as $heavyVehicle) {
            HeavyVehicle::factory()->create([
                'brand' => $heavyVehicle['brand'],
                'model' => $heavyVehicle['model'],
                'vendor_id' => $heavyVehicle['vendor_id'],
                'is_active' => $heavyVehicle['is_active'],
            ]);
        }
    }
}

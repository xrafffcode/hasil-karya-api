<?php

namespace Database\Seeders;

use App\Models\Truck;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = \App\Models\Vendor::all();

        Truck::factory()->create([
            'code' => 'TRUCK-0001',
            'brand' => 'Hino',
            'model' => 'Ranger',
            'capacity' => 10,
            'production_year' => 2019,
            'vendor_id' => $vendors->random()->id,
            'is_active' => true,
        ]);
    }
}

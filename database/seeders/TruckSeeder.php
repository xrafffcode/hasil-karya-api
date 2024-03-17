<?php

namespace Database\Seeders;

use App\Models\Truck;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trucks = [
            [
                'brand' => 'Hino',
                'model' => 'Ranger 500 Series',
                'capacity' => '7',
                'vendor_id' => Vendor::inRandomOrder()->first()->id,
                'is_active' => true,
            ],
            [
                'brand' => 'Isuzu',
                'model' => 'Elf 300',
                'capacity' => '5',
                'vendor_id' => Vendor::inRandomOrder()->first()->id,
                'is_active' => true,
            ],
            [
                'brand' => 'Mitsubishi Fuso',
                'model' => 'Canter FE71',
                'capacity' => '6',
                'vendor_id' => Vendor::inRandomOrder()->first()->id,
                'is_active' => true,
            ],
        ];

        foreach ($trucks as $truck) {
            Truck::factory()->create([
                'brand' => $truck['brand'],
                'model' => $truck['model'],
                'capacity' => $truck['capacity'],
                'vendor_id' => $truck['vendor_id'],
                'is_active' => $truck['is_active'],
            ]);
        }
    }
}

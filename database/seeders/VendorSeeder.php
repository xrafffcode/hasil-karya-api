<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            ['name' => 'Hino Indonesia'],
            ['name' => 'Isuzu Astra Motor Indonesia'],
            ['name' => 'Mitsubishi Fuso Truck and Bus Corporation'],
        ];

        foreach ($vendors as $vendor) {
            Vendor::factory()->create([
                'name' => $vendor['name'],
                'is_active' => true,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::factory()->create([
            'code' => 'VENDOR-0001',
            'name' => 'PT ABC',
            'address' => 'Jl. Raya No. 1',
            'phone' => '081234567890',
            'is_active' => true,
        ]);
    }
}

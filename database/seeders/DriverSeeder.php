<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Driver::factory()->create([
            'code' => 'DRIVER-0001',
            'name' => 'John Doe',
            'is_active' => true,
        ]);
    }
}

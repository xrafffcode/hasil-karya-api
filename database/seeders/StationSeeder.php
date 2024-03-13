<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Station::factory()->create([
            'code' => 'STATION-0001',
            'name' => 'POS 1',
            'address' => 'Jl. Raya No. 1',
            'is_active' => true,
        ]);
    }
}

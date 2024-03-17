<?php

namespace Database\Seeders;

use App\Enum\StationCategoryEnum;
use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quaries = [
            StationCategoryEnum::QUARY->value => [
                ['name' => 'POS Tambang 1'],
                ['name' => 'POS Tambang 2'],
                ['name' => 'POS Tambang 3'],
            ],
            StationCategoryEnum::DISPOSAL->value => [
                ['name' => 'POS Disposal 1'],
                ['name' => 'POS Disposal 2'],
                ['name' => 'POS Disposal 3'],
            ],
            StationCategoryEnum::GAS->value => [
                ['name' => 'POS Gas 1'],
                ['name' => 'POS Gas 2'],
                ['name' => 'POS Gas 3'],
            ],
        ];

        foreach ($quaries as $type => $stations) {
            foreach ($stations as $station) {
                Station::factory()->withoutAdministrativeUnit()->create([
                    'name' => $station['name'],
                    'category' => $type,
                    'is_active' => true,
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Enum\StationCategoryEnum;
use App\Models\Material;
use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $QuaryMaterialId = Material::where('name', 'Pasir')->first()->id;
        $GasMaterialId = Material::where('name', 'Diesel')->first()->id;

        $quaries = [
            StationCategoryEnum::QUARY->value => [
                ['name' => 'POS Tambang 1', 'material_id' => $QuaryMaterialId],
                ['name' => 'POS Tambang 2', 'material_id' => $QuaryMaterialId],
                ['name' => 'POS Tambang 3', 'material_id' => $QuaryMaterialId],
            ],
            StationCategoryEnum::DISPOSAL->value => [
                ['name' => 'POS Disposal 1'],
                ['name' => 'POS Disposal 2'],
                ['name' => 'POS Disposal 3'],
            ],
            StationCategoryEnum::GAS->value => [
                ['name' => 'POS Gas 1', 'material_id' => $GasMaterialId],
                ['name' => 'POS Gas 2', 'material_id' => $GasMaterialId],
                ['name' => 'POS Gas 3', 'material_id' => $GasMaterialId],
            ],
        ];

        foreach ($quaries as $type => $stations) {
            foreach ($stations as $station) {
                Station::factory()->withoutAdministrativeUnit()->create([
                    'name' => $station['name'],
                    'category' => $type,
                    'material_id' => $station['material_id'] ?? null,
                    'is_active' => true,
                ]);
            }
        }
    }
}

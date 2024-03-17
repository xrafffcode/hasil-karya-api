<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            ['name' => 'Pasir'],
            ['name' => 'Batu'],
            ['name' => 'Tanah'],
            ['name' => 'Diesel'],
            ['name' => 'Gasoline'],
        ];

        foreach ($materials as $material) {
            Material::factory()->create([
                'name' => $material['name'],
            ]);
        }
    }
}

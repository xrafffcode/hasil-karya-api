<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            ['name' => 'PT. Mega Konstruksi Indonesia'],
            ['name' => 'CV. Bangun Jaya Abadi'],
            ['name' => 'PT. Sejahtera Bangun Bersama'],
            ['name' => 'UD. Jaya Makmur Konstruksi'],
            ['name' => 'PT. Sentra Teknik Bangunan'],
            ['name' => 'CV. Cahaya Bangun Sejahtera'],
            ['name' => 'PT. Bangun Bersama Mandiri'],
            ['name' => 'UD. Cahaya Bakti Konstruksi'],
            ['name' => 'PT. Graha Bangun Persada'],
            ['name' => 'CV. Mitra Sejahtera Konstruksi'],
        ];

        foreach ($clients as $client) {
            Client::factory()->withoutAdministrativeUnit()->create([
                'name' => $client['name'],
            ]);
        }
    }
}

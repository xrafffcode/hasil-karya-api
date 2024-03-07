<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');

        $chekers = User::create([
            'email' => 'checker@checker.com',
            'password' => bcrypt('password'),
        ])->assignRole('checker');

        $chekers->checker()->create([
            'code' => 'CH-001',
            'name' => 'Checker 1',
            'is_active' => true,
        ]);
    }
}

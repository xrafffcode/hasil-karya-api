<?php

namespace Database\Seeders;

use App\Enum\UserRoleEnum;
use App\Models\TechnicalAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TechnicalAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create(['email' => 'technical_admin@cvhasilkarya.com']);

        TechnicalAdmin::factory()->for($user)->create();
    }
}
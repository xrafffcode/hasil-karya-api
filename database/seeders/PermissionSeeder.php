<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create_user',
            'read_user',
            'update_user',
            'delete_user',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);

        $role->givePermissionTo($permissions);
    }
}

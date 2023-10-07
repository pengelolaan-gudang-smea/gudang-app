<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // Create roles and permissions
        Role::create([
            'name' => 'WAKA',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'KKK',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'edit akun',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'mengajukan barang',
            'guard_name' => 'web'
        ]);
    }
}

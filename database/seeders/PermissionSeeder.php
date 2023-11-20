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
    public function run(): void
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
        Role::create([
            'name' => 'Admin anggaran',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'Admin gudang ',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Edit akun',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Mengajukan barang',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Edit barang',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Barang gudang',
            'guard_name' => 'web'
        ]);
    }
}

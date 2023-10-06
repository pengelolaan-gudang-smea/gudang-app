<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'username' => 'roshit',
            'email' => 'auliarasyidalzahrawi@gmail.com',
            'password' => Hash::make('rosyid07'),
        ]);
        User::create([
            'username' => 'Neptune',
            'email' => 'Neptune@gmail.com',
            'password' => Hash::make('neptune02'),
        ]);
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

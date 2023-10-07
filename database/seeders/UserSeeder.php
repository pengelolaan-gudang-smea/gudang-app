<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create users
        $user1 = User::create([
            'username' => 'roshit',
            'email' => 'auliarasyidalzahrawi@gmail.com',
            'password' => Hash::make('rosyid07'),
        ]);

        $user2 = User::create([
            'username' => 'Neptune',
            'email' => 'Neptune@gmail.com',
            'password' => Hash::make('neptune02'),
        ]);

        // Assign roles and permissions to users
        $user1->assignRole('WAKA');
        $user1->givePermissionTo('edit akun');

        $user2->assignRole('WAKA');
        $user2->givePermissionTo('edit akun');
    }
}

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
            'name' => 'roshit',
            'username' => 'roshit',
            'email' => 'auliarasyidalzahrawi@gmail.com',
            'password' => Hash::make('rosyid07'),
        ]);

        $user2 = User::create([
            'name' => 'Neptune',
            'username' => 'Neptune',
            'email' => 'Neptune@gmail.com',
            'password' => Hash::make('neptune02'),
            'jurusan_id'=>'1'
        ]);
        $user3 = User::create([
            'name' => 'Algo',
            'username' => 'Algorithm',
            'email' => 'Algorithm@gmail.com',
            'password' => Hash::make('neptune02'),
        ]);

        // Assign roles and permissions to users
        $user1->assignRole('WAKA');
        $user1->givePermissionTo('Edit akun');

        $user2->assignRole('KKK');
        $user2->givePermissionTo('Mengajukan barang');

        $user3->assignRole('Admin anggaran');
        $user3->givePermissionTo('Edit barang');
    }
}

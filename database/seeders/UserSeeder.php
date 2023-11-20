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
        $waka = User::create([
            'name' => 'Wakil Kepala Sekolah',
            'username' => 'waka',
            'email' => 'waka@gmail.com',
            'password' => Hash::make('waka123'),
        ]);
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
        $user4 = User::create([
            'name' => 'Lostvayne',
            'username' => 'Lost',
            'email' => 'Lostym@gmail.com',
            'password' => Hash::make('lost02'),
        ]);

        // Assign roles and permissions to users
        $waka->assignRole('WAKA');
        $waka->givePermissionTo('Edit akun');

        $user1->assignRole('WAKA');
        $user1->givePermissionTo('Edit akun');

        $user2->assignRole('KKK');
        $user2->givePermissionTo('Mengajukan barang');

        $user3->assignRole('Admin anggaran');
        $user3->givePermissionTo('Edit barang');

        $user4->assignRole('Admin gudang');
        $user4->givePermissionTo('Barang gudang');
    }
}

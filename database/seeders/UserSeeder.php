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
            'name' => 'Super Admin',
            'username' => 'root',
            'email' => 'root@gmail.com',
            'password' => Hash::make('rosyid07'),
        ]);

        $user2 = User::create([
            'name' => 'pak haris',
            'username' => 'rpl',
            'email' => 'rpl@gmail.com',
            'password' => Hash::make('rpl123'),
            'jurusan_id' => '1'
        ]);
        $user3 = User::create([
            'name' => 'Admin Anggaran 1',
            'username' => 'adminanggaran',
            'email' => 'adminanggaran@gmail.com',
            'password' => Hash::make('passaja123'),
        ]);
        $user4 = User::create([
            'name' => 'Admin Gudang',
            'username' => 'admingudang',
            'email' => 'admingudang@gmail.com',
            'password' => Hash::make('passaja123'),
        ]);

        // Assign roles and permissions to users
        $waka->assignRole('WAKA');
        $waka->givePermissionTo('Edit akun');

        $user1->assignRole('Super Admin');
        $user1->givePermissionTo('Edit akun');
        $user1->givePermissionTo('Mengajukan barang');
        $user1->givePermissionTo('Menyetujui barang');
        $user1->givePermissionTo('Barang gudang');

        $user2->assignRole('Pengajuan barang');
        $user2->givePermissionTo('Mengajukan barang');

        $user3->assignRole('Admin anggaran');
        $user3->givePermissionTo('Menyetujui barang');

        $user4->assignRole('Admin gudang');
        $user4->givePermissionTo('Barang gudang');
    }
}

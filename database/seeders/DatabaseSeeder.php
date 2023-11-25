<?php

namespace Database\Seeders;

use App\Models\Anggaran;
use App\Models\Barang;
use App\Models\Jurusan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
        ]);
        Barang::factory(5)->create();

     $jurusan = [
        'Rekayasa Perangkat Lunak',
        'Teknik Komputer dan Jaringan',
        'Desain Komunikasi Visual',
        'Akuntansi Keuangan Lembaga',
        'Layanan Perbankan Syariah',
        'Manajemen Perkantoran',
        'Bisnis Ritel',
        'Bisnis Daring',
     ];
     for ($i=0; $i < count($jurusan) ; $i++) {
        Jurusan::create([
            'name' => $jurusan[$i],
            'slug' => Str::slug($jurusan[$i]),
        ]);
     }

     Anggaran::factory(5)->create();
    }
}

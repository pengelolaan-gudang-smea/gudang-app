<?php

namespace Database\Seeders;

use App\Models\Anggaran;
use App\Models\Barang;
use App\Models\Jenis_barang;
use App\Models\Jurusan;
use App\Models\Limit;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

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
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            JenisAnggaranSeeder::class,
        ]);
        // Barang::factory(5)->create();
        Anggaran::create([
            'anggaran' => 10000000,
            'jenis_anggaran' => 'APBD',
            'tahun' => 2024
        ]);
        Limit::create(
            [
                'anggaran_id' => 1,
                'limit' => 8000000,
                'jurusan_id' => 1
            ]
        );

    

    }
}

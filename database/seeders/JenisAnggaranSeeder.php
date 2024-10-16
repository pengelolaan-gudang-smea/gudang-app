<?php

namespace Database\Seeders;

use App\Models\Jenis_anggaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisAnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jenis_anggaran::create([
            'name' => 'APBD',
            'tahun' => 2024
        ]);
        Jenis_anggaran::create([
            'name' => 'APBN',
            'tahun' => 2024
        ]);
    }
}

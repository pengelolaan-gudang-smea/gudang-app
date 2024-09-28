<?php

namespace App\Imports;

use App\Models\Gudang;
use App\Models\Jenis_anggaran;
use App\Models\Barang;
use App\Models\BarangGudang;
use App\Models\Jurusan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $tgl_faktur = $this->parseDate($row['tanggal_faktur']);
        $tgl_masuk = $this->parseDate($row['tanggal_masuk']);
        $harga = str_replace('.', '', $row['harga_satuan']);

        // explode jenis anggaran
        $anggaranData = explode('-', $row['jenis_anggaran']);
        $anggaranName = $anggaranData[0]; // ex: "APBD"
        $anggaranTahun = $anggaranData[1]; // ex: "2024"

        // check jenis anggaran
        $jenisAnggaran = Jenis_anggaran::where('name', $anggaranName)
                                       ->where('tahun', $anggaranTahun)
                                       ->first();

        if (!$jenisAnggaran) {
            throw new \Exception('Jenis anggaran tidak ditemukan: ' . $row['jenis_anggaran']);
        }

        $jurusan = Jurusan::where('name', $row['prodi_jurusan'])->first();

        if (!$jurusan) {
            throw new \Exception('Jurusan tidak ditemukan: ' . $row['prodi_jurusan']);
        }

        // cek if barang exists
        $barang = Barang::where('kode_barang', $row['kode_barang'])->first();
        if (!$barang) {

            $barang = Barang::create([
                'kode_barang' => $row['kode_barang'],
                'kode_rekening' => $row['kode_rekening'],
                'name' => $row['nama_barang'],
                'spek' => $row['spek_teknis'],
                'harga' => $harga,
                'stock' => $row['kuantitas_qty'],
                'satuan' => $row['satuan'],
                'jenis_barang' => $row['jenis_barang'],
                'tujuan' => $row['tujuan_barang'],
                'anggaran_id' => $jenisAnggaran->id,
                'jurusan_id' => $jurusan->id,
                'user_id' => Auth::id(),
                'sub_total' => $harga * $row['kuantitas_qty'],
            ]);
        } else {
            $barang->stock += $row['kuantitas_qty'];
            $barang->save();
        }

        $existingBarangGudang = BarangGudang::where('kode_barang', $row['kode_barang'])->first();
        if ($existingBarangGudang) {
            $existingBarangGudang->stock_awal += $row['kuantitas_qty'];
            $existingBarangGudang->stock_akhir += $row['kuantitas_qty'];
            $existingBarangGudang->save();

            return null;
        }

        $slugGudang = Str::slug($row['nama_barang']);
        $counterGudang = 2;
        while (BarangGudang::where('slug', $slugGudang)->exists()) {
            $slugGudang = Str::slug($row['nama_barang']) . '-' . $counterGudang;
            $counterGudang++;
        }

        return new BarangGudang([
            'barang_id' => $barang->id, // get id
            'kode_barang' => $row['kode_barang'],
            'kode_rekening' => $row['kode_rekening'],
            'name' => $row['nama_barang'],
            'spek' => $row['spek_teknis'],
            'stock_awal' => $row['kuantitas_qty'],
            'stock_akhir' => $row['kuantitas_qty'],
            'satuan' => $row['satuan'],
            'jurusan_id' => $jurusan->id,
            'tujuan' => $row['tujuan_barang'],
            'jenis_barang' => $row['jenis_barang'],
            'anggaran_id' => $jenisAnggaran->id,
            'tahun' => $row['tahun'],
            'tgl_faktur' => $tgl_faktur,
            'lokasi' => $row['lokasi'],
            'penerima' => $row['penerima'],
            'tgl_masuk' => $tgl_masuk,
            'slug' => $slugGudang,
        ]);
    }

    private function parseDate($value)
    {
        // If it's already in YYYY-MM format, add the last day of the month
        if (preg_match('/^\d{4}-\d{2}$/', $value)) {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }

        // If it's an Excel date serial number
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        // If it's in any other recognizable date format, try to parse it
        $timestamp = strtotime($value);
        if ($timestamp !== false) {
            return date('Y-m-d', $timestamp);
        }

        // If all else fails, return null or throw an exception
        throw new \Exception("Invalid date format: $value");
    }
}

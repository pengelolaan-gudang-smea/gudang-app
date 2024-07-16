<?php

namespace App\Imports;

use App\Models\Gudang;
use App\Models\Jenis_barang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToCollection, WithCalculatedFormulas, WithHeadingRow
{
    use Importable;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // dd('hore');
        foreach ($collection as $row) {
            dd($row);
            Gudang::create([
                'name' => $row["Nama Barang"],
                'nomor_inventaris' => $row['Nomor Inventaris'],
                'slug' => Str::slug($row["Nama Barang"]),
                'jenis_barang' => Jenis_barang::where('name', $row["Jenis Barang"])->first(),
                'stock' => $row["Stock Barang"],
                'satuan' => $row["Satuan Barang"],
                'tujuan' => $row["Tujuan Barang"],
                'barang_diambil' => $row["Barang Diambil"] ?? null,
                'spek' => $row["Spek Barang"],
                'tahun' => $row["Tahun"] ?? null,
                'tanggal_faktur' => $row["Tanggal Faktur"] ?? null,
                'status' => $row["Status"] ?? null,
            ]);
        }
    }
    public function headingRow(): int
    {
        return 1;
    }
}

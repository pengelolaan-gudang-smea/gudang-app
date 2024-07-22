<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Barang_jurusan implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data;
    }
    public function map($barang): array
    {
        // dd($barang);
        return [
            'name ' => $barang->name,
            'no_inventaris' => $barang->no_inventaris,
            'stock_awal' => $barang->stock_awal,
            'stock_akhir' => $barang->stock_akhir,
            'satuan' => $barang->satuan,
            'anggaran' => $barang->anggaran->jenis_anggaran,
            'barang_diambil' => $barang->barang_diambil,
            'jenis_barang' => $barang->jenis_barang,
            'lokasi' => $barang->lokasi,
            'jurusan' => $barang->jurusan->name,
            'tujuan' => $barang->tujuan,
            'tgl_masuk' => $barang->tgl_masuk,
            'penerima' => $barang->penerima,
            'tahun' => $barang->tahun,
        ];
    }


    public function headings(): array
    {
        return [
            'Nama Barang',
            'Nomor Inventaris',
            'Stock Awal',
            'Stock Akhir',
            'Satuan',
            'Jenis Anggaran',
            'Barang Diambil',
            'Jenis Barang',
            'Lokasi',
            'jurusan',
            'Tujuan',
            'Tanggal Masuk',
            'Penerima',
            'Tahun',
        ];
    }
}

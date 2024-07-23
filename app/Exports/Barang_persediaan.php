<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Barang_persediaan implements FromCollection,WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    protected $saldo_masuk;
    protected $saldo_akhir;
    public function __construct($data, $saldo_masuk, $saldo_akhir)
    {
        $this->data = $data;
        $this->saldo_masuk = $saldo_masuk;
        $this->saldo_akhir = $saldo_akhir;
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
            'saldo_awal' => $barang->anggaran->anggaran,
            'saldo_masuk' => $this->saldo_masuk,
            'saldo_keluar' => $barang->saldo_keluar,
            'saldo_akhir' => $this->saldo_akhir,
            'barang_diambil' => $barang->barang_diambil,
            'jenis_barang' => $barang->jenis_barang,
            'lokasi' => $barang->lokasi,
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
            'Anggaran',
            'Saldo Awal',
            'Saldo Masuk',
            'Saldo Keluar',
            'Saldo Akhir',
            'Barang Diambil',
            'Jenis Barang',
            'Lokasi',
            'Tujuan',
            'Tanggal Masuk',
            'Penerima',
            'Tahun',
        ];
    }
}

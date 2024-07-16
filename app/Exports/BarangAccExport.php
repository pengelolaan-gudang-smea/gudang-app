<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangAccExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Barang::all();
    }
    public function map($barang): array
    {
        return [
            'name ' => $barang->name,
            'no_inventaris' => $barang->no_inventaris,
            'stock' => $barang->stock,
            'satuan' => $barang->satuan,
            'harga' => $barang->harga,
            'sub_total' => $barang->sub_total,
            'status' => $barang->status,
            'keterangan' => $barang->keterangan,
            'tujuan' => $barang->tujuan,
            'spek' => $barang->spek,
            'expired' => $barang->expired,
            'jenis_barang' => $barang->jenis_barang->name,
            'jenis_anggaran' => $barang->jenis_anggaran->name,
            'user' => $barang->user->name,
            'jurusan' => $barang->jurusan->name
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Nomor Inventaris',
            'Stock Barang',
            'Satuan Barang',
            'Harga Barang',
            'Sub Total ',
            'Status',
            'Keterangan',
            'Tujuan Barang',
            'Spesifikasi',
            'Bulan yang diinginkan',
            'Jenis Barang',
            'Anggaran',
            'Nama KKK',
            'Jurusan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:O1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Warna teks judul kolom
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3366FF'], // Warna latar belakang judul kolom
            ],
        ]);

        return [];
    }
}

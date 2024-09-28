<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangGudangExport implements FromArray, WithHeadings
{
    private $iteration = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return [
            // Example row, can be left empty as this is just a format
        ];
    }

    public function map($row): array
    {
        $this->iteration++;
        return [
            $this->iteration, // Iteration column
            '', // Empty columns since you only want the header format
            '', // Empty columns since you only want the header format
            '', // And so on...
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Kode Rekening',
            'Nama Barang',
            'Harga Satuan',
            'Kuantitas (Qty)',
            'Satuan',
            'Tahun',
            'Tanggal Faktur',
            'Jenis Barang',
            'Prodi / Jurusan',
            'Tujuan Barang',
            'Jenis Anggaran',
            'Lokasi',
            'Penerima',
            'Tanggal Masuk',
            'Spek Teknis',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Text color white
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3366FF'], // Background color blue
            ],
        ]);

        // Make the iteration column bold for all rows
        $sheet->getStyle('A2:A' . ($sheet->getHighestRow()))->getFont()->setBold(true);

        return [];
    }
}

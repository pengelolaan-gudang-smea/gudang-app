<?php

namespace App\Exports;

use App\Models\Barang;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangAccExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    private $iteration = 0;
    private $jurusanId;
    private $tahun;

    public function __construct($jurusanId, $tahun)
    {
        $this->jurusanId = $jurusanId;
        $this->tahun = $tahun;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Barang::query();

        if ($this->jurusanId !== null && $this->jurusanId !== 'all' && $this->jurusanId !== 'null') {
            $query->where('jurusan_id', $this->jurusanId);
        }

        if ($this->tahun !== null && $this->tahun !== 'all' && $this->tahun !== 'null') {
            $query->whereYear('created_at', $this->tahun);
        }

        return $query->get();
    }

    public function map($barang): array
    {
        $this->iteration++;
        $keterangan = $barang->status === 'Ditolak' ? $barang->keterangan : '-';
        $approvedKeterangan = $barang->status === 'Disetujui' ? $barang->keterangan : '-';

        return [
            'No' => $this->iteration,
            'name' => $barang->name,
            'no_inventaris' => $barang->no_inventaris,
            'stock' => $barang->stock,
            'satuan' => $barang->satuan,
            'harga' => "Rp" . number_format($barang->harga, 0, ',', '.'),
            'sub_total' => "Rp" . number_format($barang->sub_total, 0, ',', '.'),
            'status' => $barang->status,
            'approved_keterangan' => $approvedKeterangan,
            'keterangan' => $keterangan,
            'tujuan' => $barang->tujuan,
            'spek' => $barang->spek,
            'expired' => Carbon::parse($barang->expired)->translatedFormat('d F Y'),
            'jenis_barang' => $barang->jenis_barang,
            'jenis_anggaran' => $barang->anggaran->jenis_anggaran . ' - ' . $barang->anggaran->tahun,
            'user' => $barang->user->name,
            'jurusan' => $barang->jurusan->name,
            'created_at' => Carbon::parse($barang->created_at)->translatedFormat('H:i, d M Y')
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'Nomor Inventaris',
            'Stock Barang',
            'Satuan Barang',
            'Harga Barang',
            'Sub Total ',
            'Status',
            'Jumlah Item Disetujui',
            'Keterangan',
            'Tujuan Barang',
            'Spesifikasi',
            'Bulan yang diinginkan',
            'Jenis Barang',
            'Anggaran',
            'Nama KKK',
            'Jurusan',
            'Waktu Pengajuan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Warna teks judul kolom
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3366FF'], // Warna latar belakang judul kolom
            ],
        ]);

        $sheet->getStyle('A2:A' . ($sheet->getHighestRow()))->getFont()->setBold(true);

        return [];
    }
}

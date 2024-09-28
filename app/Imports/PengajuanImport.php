<?php

namespace App\Imports;

use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengajuanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $expired = $this->parseDate($row['bulan_yang_diinginkan']);
        $harga = str_replace('.', '', $row['harga_satuan']);

        return new Barang([
            'kode_barang' => $row['kode_barang'],
            'kode_rekening' => $row['kode_rekening'],
            'name' => $row['nama_barang'],
            'harga' => $harga,
            'stock' => $row['kuantitas_qty'],
            'satuan' => $row['satuan'],
            'expired' => $expired,
            'user_id' => Auth::user()->id,
            'jurusan_id' => Auth::user()->jurusan->id,
            'tujuan' => $row['tujuan_barang'],
            'sub_total' => $row['harga_satuan'] * $row['kuantitas_qty'],
            'jenis_barang' => $row['jenis_barang'],
            'spek' => $row['spek_teknis'],
        ]);
    }

    private function parseDate($value)
    {
        // If it's already in YYYY-MM format, add the last day of the month
        if (preg_match('/^\d{4}-\d{2}$/', $value)) {
            return Carbon::createFromFormat('Y-m', $value)->endOfMonth()->format('Y-m-d');
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

    public function rules(): array
    {
        return [
            'kode_barang' => 'required',
            'kode_rekening' => 'required',
            'nama_barang' => 'required',
            'harga_satuan' => 'required|numeric',
            'kuantitas_qty' => 'required|numeric',
            'satuan' => 'required',
            'bulan_yang_diinginkan' => 'required|date_format:Y-m',
            'jenis_barang' => 'required',
            'spek_teknis' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kode_barang.required' => 'Kode Barang harus diisi.',
            'kode_rekening.required' => 'Kode Rekening harus diisi.',
            'nama_barang.required' => 'Nama Barang harus diisi.',
            'harga_satuan.required' => 'Harga Satuan harus diisi.',
            'harga_satuan.numeric' => 'Harga Satuan harus berupa angka.',
            'kuantitas_qty.required' => 'Kuantitas harus diisi.',
            'kuantitas_qty.numeric' => 'Kuantitas harus berupa angka.',
            'satuan.required' => 'Satuan harus diisi.',
            'bulan_yang_diinginkan.required' => 'Bulan yang diinginkan harus diisi.',
            'bulan_yang_diinginkan.date_format' => 'Format Bulan yang diinginkan harus YYYY-MM.',
            'jenis_barang.required' => 'Jenis Barang harus diisi.',
            'spek_teknis.required' => 'Spesifikasi Teknis harus diisi.',
        ];
    }
}

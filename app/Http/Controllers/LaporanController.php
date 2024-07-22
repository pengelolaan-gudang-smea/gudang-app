<?php

namespace App\Http\Controllers;

use App\Exports\Barang_persediaan;
use App\Models\Anggaran;
use App\Models\BarangGudang;
use App\Models\Gudang;
use App\Models\Saldo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index()
    {
        $jenis_laporan = session('laporan');

        if (session('jenis_anggaran')) {
            $query = BarangGudang::where('jenis_barang', 'persediaan')->where('anggaran_id', session('jenis_anggaran'));
        } else {
            $query = BarangGudang::where('jenis_barang', 'persediaan');
        }

        if ($jenis_laporan == 'hari ini') {
            $barang_gudang = $query->hariIni()->get();
        } elseif ($jenis_laporan == 'minggu ini') {
            $barang_gudang = $query->mingguIni()->get();
        } elseif ($jenis_laporan == 'bulan ini') {
            $barang_gudang = $query->bulanIni()->get();
        } else {
            $barang_gudang = $query->get();
        }
        // dd($barang_gudang->get());
        $total_saldo = $barang_gudang->sum('saldo_keluar');
        $saldo_masuk = Saldo::where('anggaran_id', session('jenis_anggaran'))->pluck('saldo_masuk')->first();
        $saldo_akhir = $saldo_masuk - $total_saldo;
        return view('dashboard.gudang.laporan', [
            'title' => 'Laporan Gudang',
            'gudang' => $barang_gudang,
            'jenis_anggaran' => Anggaran::all(),
            'saldo_awal' => Anggaran::where('id', session('jenis_anggaran'))->pluck('anggaran')->first(),
            'saldo_masuk' => Saldo::where('anggaran_id', session('jenis_anggaran'))->first(),
            'saldo_akhir' => $saldo_akhir
        ]);
    }

    public function filterLaporan(Request $request)
    {
        session(['jenis_anggaran' => $request->jenis_anggaran]);
        session(['laporan' => $request->jenis_laporan]);
        return back();
    }

    public function resetSession(Request $request)
    {
        $request->session()->forget('jenis_anggaran');
        $request->session()->forget('laporan');
        return back();
    }

    public function saldo_masuk(Request $request)
    {
        $validated = $request->validate([
            'saldo_masuk' => 'numeric',
        ]);
        $validated['anggaran_id'] = session('jenis_anggaran');
        Saldo::create($validated);
        return back()->with('success', 'Berhasil mengisi saldo masuk');
    }

    public function saldo_keluar(Request $request, $slug)
    {
        $barang = BarangGudang::where('slug', $slug)->first();
        $validated = $request->validate([
            'saldo_keluar' => 'numeric',
        ]);;
        $barang->update($validated);
        return back()->with('success', 'Berhasil mengisi saldo keluar');
    }

    public function export_laporan(Request $request)
    {
        $query = BarangGudang::query();
$query->where('jenis_barang','persediaan');
        if ($request->has('lab_ruang') && !empty($request->lab_ruang)) {
            $query->where('tujuan', $request->lab_ruang);
        }

        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('created_at', $request->tahun);
        }

        // Tambahkan filter untuk periode laporan
        if ($request->has('jenis_laporan')) {
            $jenis_laporan = $request->input('jenis_laporan');
            if ($jenis_laporan == 'hari ini') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($jenis_laporan == 'minggu ini') {
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($jenis_laporan == 'bulan ini') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            }
        }

        $barang_gudang = $query->get();

        // Hitung total saldo keluar
        $total_saldo_keluar = $barang_gudang->sum('saldo_keluar');

        // Ambil saldo masuk dari tabel Saldo berdasarkan anggaran_id
        $saldo_masuk = Saldo::where('anggaran_id', $request->input('jenis_anggaran'))->pluck('saldo_masuk')->first();

        // Hitung saldo akhir
        $saldo_akhir = $saldo_masuk - $total_saldo_keluar;

        // Tambahkan saldo_masuk dan saldo_akhir ke koleksi barang_gudang

        return Excel::download(new Barang_persediaan($barang_gudang,$saldo_masuk, $saldo_akhir), 'barang_persediaan.xlsx');
    }
}

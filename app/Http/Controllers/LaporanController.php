<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\BarangGudang;
use App\Models\Gudang;
use App\Models\Saldo;
use Illuminate\Http\Request;
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
}

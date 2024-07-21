<?php

namespace App\Http\Controllers;

use App\Models\BarangGudang;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanAsetController extends Controller
{
    public function index(){
        return view('dashboard.gudang.laporan-jurusan',[
            'title'=>'Laporan gudang',
            'gudang'=>BarangGudang::with('jurusan')->where('jenis_barang','aset')->get()
        ]);
    }

    public function laporanJurusan(Request $request)
    {
        $tahun = BarangGudang::where('jurusan_id', $request->jurusan)
            ->distinct()
            ->selectRaw('YEAR(created_at) as tahun')
            ->pluck('tahun')
            ->toArray();

        return $tahun;
    }

    public function barangJurusan(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangGudang::where('jurusan_id', $request->jurusan)->whereYear('created_at', $request->tahun)->get();

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('no inventaris', function ($q) {
                    return $q->no_inventaris;
                })
                ->addColumn('nama', function ($q) {
                    return$q->name;
                })
                ->addColumn('kuantitas (Qty)', function ($q) {
                    return $q->stock_awal;
                })
                ->addColumn('jurusan', function ($q) {
                    return$q->jurusan->name;
                })

                ->make(true);
            return $result;
        }
    }


    public function labRuang(Request $request){

        return view('dashboard.gudang.laporan-lab',[
            'title'=>'Laporan gudang',
            'gudang'=>BarangGudang::where('jenis_barang','aset')->get()
        ]);
    }

    public function laporan_ruang_lab(Request $request)
    {
        $tahun = BarangGudang::where('tujuan', $request->lab_ruang)
            ->distinct()
            ->selectRaw('YEAR(created_at) as tahun')
            ->pluck('tahun')
            ->toArray();

        return $tahun;
    }

    public function barang_ruang_lab(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangGudang::where('tujuan', $request->lab_ruang)->whereYear('created_at', $request->tahun)->get();

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('no inventaris', function ($q) {
                    return $q->no_inventaris;
                })
                ->addColumn('nama', function ($q) {
                    return$q->name;
                })
                ->addColumn('kuantitas (Qty)', function ($q) {
                    return $q->stock_awal;
                })
                ->addColumn('lokasi', function ($q) {
                    return$q->tujuan;
                })

                ->make(true);
            return $result;
        }
    }
}

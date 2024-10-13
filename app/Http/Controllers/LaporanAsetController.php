<?php

namespace App\Http\Controllers;

use App\Exports\Barang_jurusan;
use App\Exports\Barang_ruang_lab;
use App\Models\BarangGudang;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanAsetController extends Controller
{

    public function index()
    {
        return view('dashboard.gudang.laporan-jurusan', [
            'title' => 'Laporan gudang',
            'gudang' => BarangGudang::with('jurusan')->where('jenis_barang', 'Aset')->get()
        ]);
    }

    public function laporanJurusan(Request $request)
    {
        if ($request->jurusan !== 'all') {

            $tahun = BarangGudang::where('jurusan_id', $request->jurusan)
                ->distinct()
                ->pluck('tahun')
                ->toArray();
        } else if ($request->jurusan == "all") {
            $tahun = BarangGudang::distinct()->pluck('tahun')->toArray();
        }

        return $tahun;
    }

    public function barangJurusan(Request $request)
    {
        if ($request->ajax()) {

            if ($request->tahun == 'all' && $request->jurusan == 'all') {
                $data = BarangGudang::where('jenis_barang','Aset')->get();
            } else if ($request->jurusan == 'all') {
                $data = BarangGudang::where('tahun', $request->tahun)->get();
            } else if ($request->tahun == 'all') {
                $data = BarangGudang::where('jurusan_id', $request->jurusan)->get();
            } else {
                $data = BarangGudang::where('jurusan_id', $request->jurusan)->where('tahun', $request->tahun)->get();
            }
        }
        $result = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('no inventaris', function ($q) {
                return $q->no_inventaris;
            })
            ->addColumn('nama', function ($q) {
                return $q->name;
            })
            ->addColumn('kuantitas (Qty)', function ($q) {
                return $q->stock_awal;
            })
            ->addColumn('jurusan', function ($q) {
                return $q->jurusan->name;
            })

            ->make(true);
        return $result;
    }



    public function labRuang(Request $request)
    {

        return view('dashboard.gudang.laporan-lab', [
            'title' => 'Laporan gudang',
            'gudang' => BarangGudang::where('jenis_barang', 'aset')->get()
        ]);
    }

    public function laporan_ruang_lab(Request $request)
    {
        if ($request->lab_ruang !== 'all') {

            $tahun = BarangGudang::where('tujuan', $request->lab_ruang)
                ->distinct()
                ->pluck('tahun')
                ->toArray();
        } else {
            $tahun = BarangGudang::distinct()->pluck('tahun')->toArray();
        }

        return $tahun;
    }

    public function barang_ruang_lab(Request $request)
    {
        if ($request->ajax()) {
            if ($request->tahun == 'all' && $request->lab_ruang == 'all') {
                $data = BarangGudang::all();
            } else if ($request->lab_ruang == 'all') {
                $data = BarangGudang::where('tahun', $request->tahun)->get();
            } else if ($request->tahun == 'all') {
                $data = BarangGudang::where('tujuan', $request->lab_ruang)->get();
            } else {
                $data = BarangGudang::where('tujuan', $request->lab_ruang)->where('tahun', $request->tahun)->get();
            }
            // $data = BarangGudang::where('tujuan', $request->lab_ruang)->whereYear('created_at', $request->tahun)->get();

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('no inventaris', function ($q) {
                    return $q->no_inventaris;
                })
                ->addColumn('nama', function ($q) {
                    return $q->name;
                })
                ->addColumn('kuantitas (Qty)', function ($q) {
                    return $q->stock_awal;
                })
                ->addColumn('lokasi', function ($q) {
                    return $q->tujuan;
                })

                ->make(true);
            return $result;
        }
    }

    public function export_laporan_jurusan(Request $request)
    {
        $query = BarangGudang::query();

        if ($request->has('jurusan') && !empty($request->jurusan) && $request->jurusan != 'all') {
            $query->where('jurusan_id', $request->jurusan);
        }

        if ($request->has('tahun') && !empty($request->tahun) && $request->tahun != 'all') {
            $query->where('tahun', $request->tahun);
        }


        $data = $query->get();
        return Excel::download(new Barang_jurusan($data), 'barang_jurusan.xlsx');
    }
    public function export_laporan_ruang_lab(Request $request)
    {
        $query = BarangGudang::query();

           if ($request->has('lab_ruang') && !empty($request->lab_ruang) && $request->lab_ruang != 'all') {
            $query->where('tujuan', $request->lab_ruang);
        }

        if ($request->has('tahun') && !empty($request->tahun) && $request->tahun != 'all') {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->get();
        return Excel::download(new Barang_ruang_lab($data), 'barang_ruang_lab.xlsx');
    }
}

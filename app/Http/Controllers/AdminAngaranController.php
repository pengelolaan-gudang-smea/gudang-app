<?php

namespace App\Http\Controllers;

use App\Exports\BarangAccExport;
use App\Models\Anggaran;
use Carbon\Carbon;
use App\Models\Barang;
use App\Models\BarangGudang;
use App\Models\Jenis_anggaran;
use App\Models\Jenis_barang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminAngaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.admingaran.anggaran', [
            'title' => 'Barang diajukan',
            'barang' => Barang::all(),
            'anggaran' => Anggaran::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {

        $barang = Barang::where('slug', $slug)->with('anggaran')->first();
        $barang->created_at_formatted = Carbon::parse($barang->created_at)->format('j F Y');
        $barang->expired_formatted = Carbon::parse($barang->expired)->format('F Y');

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil',
            'barang' => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $acc)
    {
        return view('dashboard.admingaran.edit', [
            'title' => 'Edit Barang',
            'barang' => $acc
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $acc)
    {
        try {
            if ($request->has('persetujuan')) {

                // ? Update Barang jika di setujui
                $validated = $request->validate([
                    'persetujuan' => 'required',
                    'jenis_anggaran' => 'required'
                ]);

                $validated['persetujuan'] = $request->input('persetujuan');
                $validated['jenis_anggaran'] = $request->input('jenis_anggaran');
                $acc->update([
                    'status' => 'Disetujui',
                    'keterangan' => $validated['persetujuan'],
                    'anggaran_id' => $validated['jenis_anggaran']
                ]);
                $message = 'Disetujui';
                // dd($acc);

                // ? Masukan Barang yang sudah disetujui ke Barang_Gudang
                $barangGudang = BarangGudang::where('name', $acc->name)->where('jenis_barang', $acc->jenis_barang)->get();
                // dd($barangGudang);
                if ($barangGudang->isNotEmpty()) {
                    foreach ($barangGudang as $barang_gudang) {
                        $barang_gudang->increment('stock', $request->input('persetujuan'));
                    }
                } else {
                    BarangGudang::create([
                        'name' => $acc->name,
                        'spek' => $acc->spek,
                        'no_inventaris' => $acc->no_inventaris,
                        'slug' => $acc->slug,
                        'stock_awal' => $request->input('persetujuan'),
                        'stock_akhir' => $request->input('persetujuan'),
                        'barang_id' => $acc->id,
                        'tahun' => Carbon::now()->year,
                        'satuan' => $acc->satuan,
                        'tujuan' => $acc->tujuan,
                        'jenis_barang' => $acc->jenis_barang,
                        'anggaran_id' => $acc->anggaran_id,
                        'jurusan_id' => $acc->jurusan_id,
                    ]);
                }

                // ? Set Activity
                activity()->performedOn(new Barang())->event('accepted')
                    ->withProperties(['attributes' => [
                        'name' => $acc->name,
                        'harga' => $acc->harga,
                        'satuan' => $acc->satuan,
                        'spek' => $acc->spek,
                    ]])
                    ->log('Menyetujui barang yang diajukan oleh ' . $acc->user->username);
                return back()->with('success', 'Barang ' . $message);
            } elseif ($request->has('penolakan')) {

                // ? Set Activity
                activity()->performedOn(new Barang())->event('rejected')
                    ->withProperties(['attributes' => [
                        'name' => $acc->name,
                        'harga' => $acc->harga,
                        'satuan' => $acc->satuan,
                        'spek' => $acc->spek,
                    ]])->log('Menolak barang yang diajukan oleh ' . $acc->user->username);

                // ? UPdate Barang jika status ditolak
                $acc->update([
                    'status' => 'Ditolak',
                    'keterangan' => $request->input('penolakan')
                ]);
                $message = 'Ditolak';

                // ? Kurangi stock barang gudang sesuai jumlah yang di setujui
                $barang = BarangGudang::where('barang_id', $acc->id)->first();
                $barangGudang = BarangGudang::where('name', $acc->name)->where('jenis_barang', $acc->jenis_barang)->get();
                foreach ($barangGudang as $barang_gudang) {
                    $barang_gudang->decrement('stock', $acc->stock);
                }
                if ($barang) {
                    $barang->delete();
                }
                return back()->with('success', 'Barang ' . $message);
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function EditBarangPersetujuan(Request $request, $slug)
    {
        // dd('masuk');
        $barang_update = Barang::where('slug', $slug)->first();
        $barang_gudang = BarangGudang::where('slug', $slug)->first();

        $barang_update->update([
            'keterangan' => $request->input('jumlahBarang'),
            'anggaran_id' => $request->input('jenis_anggaran'),
        ]);

        $barang_gudang->update([
            'stock' => $request->input('jumlahBarang'),
            'anggaran_id' => $request->input('jenis_anggaran'),
        ]);
        return back()->with('success', 'Berhasil mengedit barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $acc)
    {
    }

    public function filterJurusan(Request $request)
    {
        $tahun = Barang::where('jurusan_id', $request->jurusan)
            ->distinct()
            ->selectRaw('YEAR(created_at) as tahun')
            ->pluck('tahun')
            ->toArray();

        return $tahun;
    }

    public function filterBarang(Request $request)
    {
        if ($request->ajax()) {
            $data = Barang::where('jurusan_id', $request->jurusan)->whereYear('created_at', $request->tahun)->get();

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($q) {
                    return $q->name;
                })
                ->addColumn('harga', function ($q) {
                    return 'Rp ' . number_format($q->harga, 0, ',', '.');
                })
                ->addColumn('stock', function ($q) {
                    return $q->stock;
                })
                ->addColumn('sub_total', function ($q) {
                    return 'Rp ' . number_format($q->sub_total, 0, ',', '.');
                })
                ->addColumn('status', function ($q) {
                    return $q->status;
                })
                ->addColumn('action', function ($q) {
                    return $q->slug;
                })
                ->make(true);
            return $result;
        }
    }


    public function export()
    {
        // dd('halo');
        return Excel::download(new BarangAccExport, 'Barang-acc.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Jurusan;
use Illuminate\Support\Str;
use App\Models\BarangGudang;
use Illuminate\Http\Request;
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
            'barang' => Barang::all()
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
    public function show(string $id)
    {
        //
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
        if ($request->has('status')) {
            $status = $request->input('status');
            $acc->update(['status' => $status]);
            if ($status == 'Disetujui') {
                BarangGudang::create([
                    'name' => $acc->name,
                    'slug' => $acc->slug,
                    'spek' => $acc->spek,
                    'satuan' => $acc->satuan,
                    'tahun' => Carbon::now()->year,
                ]);
            }
            return back()->with('success', 'Barang ' . $status);
        }

        $validate = $request->validate([
            'name' => 'required',
            'spek' => 'required',
            'harga' => ['required', 'numeric'],
            'satuan' => 'required'
        ]);

        $subtotal = $validate['harga'] * $validate['satuan'];

        if ($validate['name'] !== $acc->name) {
            $slug = $validate['slug'] = Str::slug($validate['name']);
            $counter = 2;
            while (Barang::where('slug', $slug)->exists()) {
                $slug = Str::slug($validate['name']) . '-' . $counter;
                $counter++;
            }
            $validate['slug'] = $slug;
        }
        $validate['sub_total'] = $subtotal;

        $acc->update($validate);
        return redirect()->route('barang-acc.index')->with('success', 'Berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $acc)
    {
        $acc->delete();
        return back();
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
                ->addColumn('satuan', function ($q) {
                    return $q->satuan;
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
}

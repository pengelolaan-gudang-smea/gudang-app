<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Limit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grand_total = Barang::where('user_id', Auth::user()->id)->sum('sub_total');
        $limit = Limit::where('jurusan_id',Auth::user()->jurusan->id)->sum('limit');
        $sisa = $limit - $grand_total;
        return view('dashboard.kkk.barang', [
            'title' => 'Pengajuan Barang',
            'barang' => Barang::where('user_id',Auth::user()->id)->Search(request('search'))->get(),
            'grand_total' => $grand_total,
            'limit'=>$limit,
            'sisa'=>$sisa
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grand_total = Barang::where('user_id', Auth::user()->id)->sum('sub_total');
        $limit = Limit::where('jurusan_id',Auth::user()->jurusan->id)->sum('limit');
        $sisa = $limit - $grand_total;
        return view('dashboard.kkk.create', [
            'title' => 'Ajukan Barang',
            'grand_total' => $grand_total,
            'limit'=>$limit,
            'sisa'=>$sisa
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'spek' => 'required',
            'harga' => ['required', 'numeric'],
            'satuan' => 'required',
            'user_id' => 'required',
            'jurusan_id' => 'required',
        ]);

        $subtotal = $validate['harga'] * $validate['satuan'];

        $slug = $validate['slug'] = Str::slug($validate['name']);
        $counter = 2;
        while (Barang::where('slug', $slug)->exists()) {
            $slug = Str::slug($validate['name']) . '-' . $counter;
            $counter++;
        }
        $validate['slug'] = $slug;
        $validate['sub_total'] = $subtotal;

        Barang::create($validate);
        return redirect()->route('pengajuan-barang.index')->with('success', 'Berhasil mengajukan barang');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $barang = Barang::where('slug', $slug)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil',
            'barang' => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return view('dashboard.kkk.edit', [
            'title' => 'Edit Barang',
            'barang' => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validate = $request->validate([
            'name' => 'required',
            'spek' => 'required',
            'harga' => ['required', 'numeric'],
            'satuan' => 'required'
        ]);

        $subtotal = $validate['harga'] * $validate['satuan'];

        if ($validate['name'] !== $barang->name) {
            $slug = $validate['slug'] = Str::slug($validate['name']);
            $counter = 2;
            while (Barang::where('slug', $slug)->exists()) {
                $slug = Str::slug($validate['name']) . '-' . $counter;
                $counter++;
            }
            $validate['slug'] = $slug;
        }
        $validate['sub_total'] = $subtotal;

        $barang->update($validate);
        return redirect()->route('pengajuan-barang.index')->with('success', 'Berhasil mengubah data barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return back();
    }


    public function setuju()
    {
        return view('dashboard.kkk.setuju', [
            'title' => 'Barang disetujui',
            'barang' => Barang::where('status', 'Disetujui')->get()
        ]);
    }
}

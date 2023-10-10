<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.barang.barang', [
            'title' => 'Pengajuan Barang',
            'barang' => Barang::Search(request('search'))->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.barang.create', [
            'title' => 'Ajukan Barang'
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
            'satuan' => 'required'
        ]);

        $slug = $validate['slug'] = Str::slug($validate['name']);
        $counter = 2;
        while (Barang::where('slug', $slug)->exists()) {
            $slug = Str::slug($validate['name']) . '-' . $counter;
            $counter++;
        }
        $validate['slug'] = $slug;

        Barang::create($validate);
        return redirect()->route('pengajuan-barang.index')->with('success', 'Berhasil mengajukan barang');
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
    public function edit(Barang $barang)
    {
        return view('dashboard.barang.edit', [
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
        if ($validate['name'] !== $barang->name) {
            $slug = $validate['slug'] = Str::slug($validate['name']);
            $counter = 2;
            while (Barang::where('slug', $slug)->exists()) {
                $slug = Str::slug($validate['name']) . '-' . $counter;
                $counter++;
            }
            $validate['slug'] = $slug;
        }
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
        return view('dashboard.barang.setuju', [
            'title' => 'Barang disetujui',
            'barang' => Barang::where('status', 'Disetujui')->get()
        ]);
    }
}

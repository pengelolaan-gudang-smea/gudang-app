<?php

namespace App\Http\Controllers;

use App\Models\BarangGudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.gudang.gudang', [
            'title' => 'Barang Gudang',
            'barang' => BarangGudang::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.gudang.create',[
            'title'=>'Tambah Barang Gudang'
        ]);
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
    public function edit(BarangGudang $gudang)
    {
        return view('dashboard.gudang.edit',[
            'title'=>'Edit Barang Gudang',
            'barang'=>$gudang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangGudang $gudang)
    {
        if ($request->has('keterangan')) {
            $keterangan = $request->input('keterangan');
            // dd('berhasil');
            $gudang->update(['keterangan' => $keterangan]); 
            return redirect()->route('barang-gudang.index')->with('success','Berhasil menambah penerima barang');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

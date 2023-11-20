<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Barang;
use App\Models\Limit;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.waka.anggaran.anggaran', [
            'title' => 'List Anggaran',
            'anggaran' => Anggaran::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.waka.anggaran.create', [
            'title' => 'Tambah Anggaran'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'anggaran' => ['required', 'numeric'],
            'jenis' => 'required',
            'tahun' => 'required',
        ]);

        Anggaran::create($validate);
        return redirect()->route('anggaran.index')->with('success', 'Berhasil menambahkan anggaran');
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
    public function edit(Anggaran $anggaran)
    {
        return view('dashboard.waka.anggaran.edit', [
            'title' => 'Edit Anggaran',
            'anggaran' => $anggaran
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggaran $anggaran)
    {
        $validate = $request->validate([
            'anggaran' => ['required', 'numeric'],
            'jenis' => 'required',
            'tahun' => 'required',
        ]);

        $anggaran->update($validate);
        return redirect()->route('anggaran.index')->with('success', 'Behasil mengubah data anggaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggaran $anggaran)
    {
        $anggaran->delete();

        return redirect()->route('anggaran.index')->with('success', 'Berhasil menghapus data anggaran');
    }

    public function checkAnggaran($id)
    {
        $limit = Limit::where('anggaran_id', $id)->sum('limit');
        if ($limit <= 0) {
            $limit = Anggaran::where('id', $id)->value('anggaran');
        }else{

        }
       
        return response()->json($limit);
    }
}

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
            'anggaran' => ['required'],
            'jenis' => 'required',
            'tahun' => 'required',
        ]);

        $anggaran = new Anggaran();
        $anggaran->anggaran = str_replace('.', '', $validate['anggaran']);
        $anggaran->jenis = $validate['jenis'];
        $anggaran->tahun = $validate['tahun'];
        $anggaran->save();

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
            'anggaran' => ['required'],
            'jenis' => 'required',
            'tahun' => 'required',
        ]);
        
        $anggaran->anggaran = str_replace('.', '', $validate['anggaran']);
        $anggaran->jenis = $validate['jenis'];
        $anggaran->tahun = $validate['tahun'];
        $anggaran->update();

        return redirect()->route('anggaran.index')->with('success', 'Berhasil mengubah data anggaran');
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
        $anggaran = Anggaran::where('id',$id)->value('anggaran');
        if ($limit > 0) {
            $total = $anggaran - $limit;
        }else{
            $total = Anggaran::where('id', $id)->value('anggaran');
        }

        if($total <= 0){
            return response()->json(['status'=>'limit reach']);
        }

        return response()->json($total);
    }
}

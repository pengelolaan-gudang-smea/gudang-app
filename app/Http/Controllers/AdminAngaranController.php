<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminAngaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.admingaran.anggaran', [
            'title' => 'Barang diajukan',
            'barang' => Barang::Search(request('search'))->get()
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
        return view('dashboard.admingaran.edit',[
            'title'=>'Edit Barang',
            'barang'=>$acc
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $acc)
    {
        if($request->has('status')){
        $status = $request->input('status');
        $acc->update(['status'=>$status]);
        return back()->with('success','Barang '.$status);
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
        return redirect()->route('barang-acc.index')->with('success','Berhasil mengedit data');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $acc)
    {
        $acc->delete();
        return back();
    }
}
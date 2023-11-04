<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Jurusan;
use App\Models\Limit;
use Illuminate\Http\Request;

class LimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.waka.limit.limit',[
            'title'=>'Limit Anggaran',
            'anggaran'=>Limit::with('jurusan','anggaran')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.waka.limit.create',[
            'title'=>'Atur Limit Anggaran',
            'jurusan'=>Jurusan::all(),
            'anggaran'=>Anggaran::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'limit'=> ['','numeric'],
            'jurusan_id'=>'',
            'anggaran_id'=>''
        ]);
        Limit::create($validate);
        return redirect()->route('limit-anggaran.index')->with('success','Behasil mengatur limit anggaran');
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
    public function edit(Limit $limit)
    {
        return view('dashboard.waka.limit.edit',[
            'title'=>'Edit limit anggaran',
            'limit'=>$limit,
            'anggaran'=>anggaran::all(),
            'jurusan'=>Jurusan::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Limit $limit)
    {
        $validate = $request->validate([
            'limit'=>['required','numeric'],
            'anggaran_id'=>'required',
            'jurusan_id'=>'required'
        ]);

        $limit->update($validate);
        return redirect()->route('limit-anggaran.index')->with('success','Berhasil merubah limit anggaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Limit $limit)
    {
        $limit->delete();
        return back();
    }
}

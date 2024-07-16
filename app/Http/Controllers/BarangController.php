<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Limit;
use App\Models\Barang;
use App\Models\Jenis_barang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct()
    // {
    //      if (!Auth::user()->jurusan_id) {
    //         return back();
    //     }
    // }
    public function index()
    {

        $grand_total = Barang::where('user_id', Auth::user()->id)->where('status','<>','DiTolak')->sum('sub_total');
        $limit = Limit::where('jurusan_id',Auth::user()->jurusan->id)->sum('limit');
        $sisa = $limit - $grand_total;
        return view('dashboard.kkk.barang', [
            'title' => 'Pengajuan Barang',
            'barang' => Barang::where('user_id',Auth::user()->id)->get(),
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
            'sisa' => $sisa,
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
            'harga' => 'required',
            'stock' => 'required|numeric',
            'jenis_barang' => 'required',
            'tujuan' => 'nullable',
            'satuan' => 'required',
            'user_id' => 'required',
            'jurusan_id' => 'required',
            'expired' => 'required'
        ]);
        $harga = str_replace('.', '', $validate['harga']);
        $validate['harga'] = $harga;
        $subtotal = $harga * $validate['stock'];
        $validate['expired'] = $validate['expired'] . '-01';

        $slug = $validate['slug'] = Str::slug($validate['name']);
        $counter = 2;
        while (Barang::where('slug', $slug)->exists()) {
            $slug = Str::slug($validate['name']) . '-' . $counter;
            $counter++;
        }
        $validate['slug'] = $slug;
        $validate['sub_total'] = $subtotal;

        activity()
        ->causedBy(Auth::user())
        ->performedOn(new Barang())->event('created')
        ->withProperties(['attributes' => [
            'name' => $validate['name'],
            'harga' => $validate['harga'],
            'stock' => $validate['stock'],
            'spek' => $validate['spek'],
        ]])
        ->log('Mengajukan barang');
        // dd($validate);

        Barang::create($validate);
        return redirect()->route('pengajuan-barang.index')->with('success', 'Berhasil mengajukan barang');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $barang = Barang::where('slug', $slug)->first();
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
    public function edit(Barang $barang)
    {
        $grand_total = Barang::where('user_id', Auth::user()->id)->sum('sub_total');
        $limit = Limit::where('jurusan_id', Auth::user()->jurusan->id)->sum('limit');
        $sisa = $limit - $grand_total;
        return view('dashboard.kkk.edit', [
            'title' => 'Edit Barang',
            'barang' => $barang,
            'sisa' => $sisa
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
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
            'jenis_barang_id' => 'required',
            'tujuan' => 'nullable',
            'satuan' => 'required',
            'expired' => 'required'
        ]);

        $harga = str_replace('.', '', $validate['harga']);
        $validate['harga'] = $harga;
        $subtotal = $harga * $validate['stock'];
        $validate['expired'] = $validate['expired'] . '-01';

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

        activity()->performedOn(new Barang())->event('edited')
        ->withProperties(['old' => [
            'name' => $barang->name,
            'harga' => $barang->harga,
            'stock' => $barang->stock,
            'spek' => $barang->spek,
        ]])
        ->log('Mengubah data barang');

        $barang->update($validate);

        return redirect()->route('pengajuan-barang.index')->with('success', 'Berhasil mengubah data barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        activity()->performedOn(new Barang())->event('deleted')
        ->withProperties(['old' => [
            'name' => $barang->name,
            'harga' => $barang->harga,
            'satuan' => $barang->satuan,
            'spek' => $barang->spek,
            'stock' => $barang->stock
        ]])
        ->log('Menghapus barang');

        $barang->delete();
        return redirect()->back()->with('success','Behasil menghapus data barang');
    }


    public function setuju()
    {
        $userJurusan = Auth::user()->jurusan->slug;
        $barang = Barang::where('status', 'Disetujui')->whereHas('jurusan', function($query) use ($userJurusan) {
            $query->where('slug', $userJurusan);
        })->get();
        return view('dashboard.kkk.setuju', [
            'title' => 'Barang disetujui',
            'barang' => $barang
        ]);
    }
}

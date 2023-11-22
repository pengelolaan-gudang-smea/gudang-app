<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\BarangGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.gudang.gudang', [
            'title' => 'Barang Gudang',
            'barang' => BarangGudang::latest()->get(),
            'anggaran' => Anggaran::latest()->get(),
            'qrcode' => ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.gudang.create', [
            'title' => 'Tambah Barang Gudang'
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
    public function show(string $slug)
    {
        $barang = BarangGudang::where('slug', $slug)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil',
            'barang' => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangGudang $gudang)
    {
        return view('dashboard.gudang.edit', [
            'title' => 'Edit Barang Gudang',
            'barang' => $gudang
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
            return redirect()->route('barang-gudang.index')->with('success', 'Berhasil  Menerima Barang');
        } else if ($request->has('pengambilan')) {
            $pengambilan = $request->input('pengambilan');
            $gudang->satuan -= $pengambilan;
            // dd('berhasil');
            $gudang->save();
            return redirect()->route('barang-gudang.index')->with('success', 'Berhasil Mengambil Barang');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function Qr(Request $request, $slug)
    {
        $barang = BarangGudang::where('slug', $slug)->first();
        $data = [
            'nama_barang' => $barang->name,
            'lokasi' => $request->input('lokasi'),
            'anggaran' => $request->input('anggaran') 
        ];

        $dataToEncode = json_encode($data); 

        // Generate QR code
        $qrCode = QrCode::format('png')->size(300)->generate($dataToEncode);
        if ($barang->qr_code) {
            Storage::delete($barang->qr_code);
            $filename = 'qr_codes/' . time() . '_qr.png'; 
            $path = storage_path('app/public/' . $filename);
            file_put_contents($path, $qrCode);
        }
        $filename = 'qr_codes/' . time() . '_qr.png'; 
        $path = storage_path('app/public/' . $filename);
        file_put_contents($path, $qrCode);

        BarangGudang::where('slug', $slug)->update(['qr_code' => $filename]);

        return redirect()->route('barang-gudang.index')->with('success', 'berhasil membuat qrcode');
    }

    public function generateQr(Request $request, $slug)
    {
        $barang = BarangGudang::where('slug', $slug)->first();
        dd($barang);
        $data = [
            'nama_barang' => $barang->name,
            'lokasi' => $request->input('lokasi'),
            'anggaran' => $request->input('anggaran') 
        ];

        $dataToEncode = json_encode($data); 

        $qrCode = QrCode::format('png')->size(100)->generate($dataToEncode);
        $base64QrCode = 'data:image/png;base64,' . base64_encode($qrCode);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil',
            'qrcode' => $base64QrCode
        ]);
    }
}

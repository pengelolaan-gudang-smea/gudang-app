<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Support\Str;
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
        $validatedData = $request->validate([
            'name' => 'required|string',
            'satuan' => 'required|numeric',
            'spek' => 'required|string',
            'tahun' => 'required|numeric',
        ]);

        $slug = $validatedData['slug'] = Str::slug($validatedData['name']);
        $counter = 2;
        while (BarangGudang::where('slug', $slug)->exists()) {
            $slug = Str::slug($validatedData['name']) . '-' . $counter;
            $counter++;
        }
        $validatedData['slug'] = $slug;

        activity()->performedOn(new BarangGudang())->event('created')
            ->withProperties(['attributes' => [
                'name' => $validatedData['name'],
                'satuan' => $validatedData['satuan'],
                'spek' => $validatedData['spek'],
                'tahun' => $validatedData['tahun'],
            ]])
            ->log('Menambahkan barang gudang');

        BarangGudang::create($validatedData);

        return redirect()->route('barang-gudang.index')->with('success', 'Berhasil menambah barang');
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
            $gudang->update(['keterangan' => $keterangan]);
            activity()->performedOn(new BarangGudang())->event('edited')
                ->withProperties(['attributes' => [
                    'keterangan' => $gudang->keterangan,
                ]])
                ->log('Barang diterima oleh ' . $gudang->keterangan);
            return redirect()->route('barang-gudang.index')->with('success', 'Berhasil  Menerima Barang');
        } else if ($request->has('pengambilan')) {
            $pengambilan = $request->input('pengambilan');
            $gudang->satuan -= $pengambilan;
            $gudang->save();
            activity()->performedOn(new BarangGudang())->event('edited')
                ->log('Barang diambil oleh petugas lapangan  ');
            return redirect()->route('barang-gudang.index')->with('success', 'Berhasil Mengambil Barang');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangGudang $gudang)
    {
        activity()->performedOn(new BarangGudang())->event('deleted')
        ->withProperties(['old' => [
            'name' => $gudang->name,
            'satuan' => $gudang->satuan,
            'spek' => $gudang->spek,
            'tahun' => $gudang->tahun,
        ]])
        ->log('Mengubah data barang gudang');

        $gudang->delete();
        return back()->with('success','Berhasil menghapus barang gudang');
    }

    public function Qr(Request $request, $slug)
    {
        $barang = BarangGudang::where('slug', $slug)->first();
        $data = [
            'uuid' => $barang->uuid,
            'nama_barang' => $barang->name,
            'lokasi' => $request->input('lokasi'),

        ];

        $anggaran  = Anggaran::where('id', $request->anggaran)->first();
        $data['anggaran'] = $anggaran->jenis . "-" . $anggaran->tahun;        // Generate QR code
        $dataToEncode = json_encode($data);

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

        BarangGudang::where('slug', $slug)->update([
            'lokasi' => $data['lokasi'], 'anggaran_id' => $request->anggaran,
            'qr_code' => $filename
        ]);

        activity()->performedOn(new BarangGudang())->event('created')
            ->log('Menambahkan kode QR ');

        return redirect()->route('barang-gudang.index', ['qr_created' => true, 'qr_code' => $filename])->with('success', 'Berhasil membuat kode QR');
    }

    public function printQr($slug)
    {
        $barang = BarangGudang::where('slug', $slug)->first();
        $qrCodeUrl = asset('storage/' . $barang->qr_code);

        return view('dashboard.gudang.print', compact('qrCodeUrl'));
    }
}

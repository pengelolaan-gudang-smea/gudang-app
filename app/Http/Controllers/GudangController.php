<?php

namespace App\Http\Controllers;

use App\Imports\BarangImport;
use App\Models\Anggaran;
use App\Models\Barang_keluar;
use Illuminate\Support\Str;
use App\Models\BarangGudang;
use App\Models\Jenis_anggaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
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
            'title' => 'Tambah Barang Gudang',
            'jenis_anggaran' => Anggaran::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string',
            'kode_rekening' => 'required|string',
            'name' => 'required|string',
            'stock_awal' => 'required|required',
            'satuan' => 'required',
            'tujuan' => 'nullable',
            'tahun' => 'required|numeric',
            'tgl_faktur' => 'required|date',
            'jenis_barang' => 'required',
            'lokasi' => 'required',
            'penerima' => 'required',
            'tgl_masuk' => 'required|date',
            'jurusan_id' => 'nullable',
            'anggaran_id' => 'required',
            'spek' => 'required|string',
        ]);
        $validatedData['stock_akhir'] = $validatedData['stock_awal'];

        $kode_barang = BarangGudang::where('kode_barang',$validatedData['kode_barang'])->first();
        if($kode_barang){
            $kode_barang->stock_awal += $validatedData['stock_awal'];
            $kode_barang->stock_akhir += $validatedData['stock_awal'];
            // dd($kode_barang->stock_awal);
            $kode_barang->save();
        return redirect()->route('barang-gudang.index')->with('success', 'Berhasil menambah barang');

        }else{
        $slug = $validatedData['slug'] = Str::slug($validatedData['name']);
        $counter = 2;
        while (BarangGudang::where('slug', $slug)->exists()) {
            $slug = Str::slug($validatedData['name']) . '-' . $counter;
            $counter++;
        }
        $validatedData['slug'] = $slug;
        $kode_barang = $request->input('kode_barang');

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
        if ($request->has('penerima')) {
            $penerima = $request->input('penerima');
            $gudang->update(['penerima' => $penerima, 'tgl_faktur' => Carbon::now('Asia/Jakarta')]);
            activity()->performedOn(new BarangGudang())->event('edited')
                ->withProperties(['attributes' => [
                    'penerima' => $gudang->penerima,
                ]])
                ->log('Barang diterima oleh ' . $gudang->penerima);
            return redirect()->route('barang-gudang.index')->with('success', 'Berhasil  Menerima Barang');
        } else if ($request->has('pengambilan')) {
            $pengambilan = $request->input('pengambilan');
            $diambil = $request->input('nama_pengambil');
            $tujuan = $request->input('tujuan');
            $gudang->barang_diambil = $diambil;
            $gudang->tujuan = $tujuan;
            $gudang->stock_akhir -= $pengambilan;
            $gudang->save();
            $barangKeluar = Barang_keluar::where('nama_barang', $gudang->name)
                ->where('nama_pengambil', $diambil)
                ->where('tujuan', $tujuan)
                ->first();
            if ($barangKeluar) {
                $barangKeluar->jumlah_pengambilan += $pengambilan;
                $barangKeluar->save();
            } else {
                Barang_keluar::create([
                    'nama_barang' => $gudang->name,
                    'nama_pengambil' => $diambil,
                    'tujuan' => $tujuan,
                    'jumlah_pengambilan' => $pengambilan,
                    'tgl_pengambilan' => Carbon::now('Asia/Jakarta'),
                    'qrCode' => $gudang->qr_code
                ]);
            }
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
        return back()->with('success', 'Berhasil menghapus barang gudang');
    }

    public function barangMasuk(Request $request)
    {
        dd($request->all());
    }


    public function Qr(Request $request, $slug)
    {
        $barang = BarangGudang::where('slug', $slug)->first();
        $data = [
            'uuid' => $barang->uuid,
            'nama_barang' => $barang->name,
            'lokasi' => $request->input('lokasi'),
            'jenis_barang' => $barang->jenis_barang,
            'jurusan' => $barang->barang->jurusan->name ?? '-'
        ];

        $anggaran  = Anggaran::where('id', $barang->anggaran_id)->first();
        // dd($anggaran);
        $data['jenis_anggaran'] = $anggaran->jenis_anggaran;
        $data['tahun_anggaran'] = $anggaran->tahun;

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
            'lokasi' => $data['lokasi'],
            'tgl_faktur' => Carbon::now(),
            'qr_code' => $filename
        ]);

        activity()->performedOn(new BarangGudang())->event('created')
            ->log('Menambahkan kode QR ');

        return redirect()->route('barang-gudang.index', ['qr_created' => true, 'qr_code' => $filename]);
    }

    public function printQr($slug)
    {
        $barang = BarangGudang::where('slug', $slug)->first();
        $qrCodeUrl = asset('storage/' . $barang->qr_code);

        return view('dashboard.gudang.print', compact('qrCodeUrl'));
    }


    public function import(Request $request)
    {
        $file = $request->validate([
            'file' => 'mimes:xlsx,csv'
        ]);

        $excel = $file['file'];

        try {
            Excel::import(new BarangImport, $excel);
            return redirect()->back()->with('success', 'Data berhasil diimport.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimport data.')->withErrors($failures);
        }
    }

    public function pengajuanBarang()
    {
        return view("dashboard.gudang.pengajuan-barang", [
            'title' => "Pengajuan Barang"
        ]);
    }
}

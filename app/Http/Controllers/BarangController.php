<?php

namespace App\Http\Controllers;

use App\Imports\PengajuanImport;
use Carbon\Carbon;
use App\Models\Limit;
use App\Models\Barang;
use App\Models\BarangGudang;
use App\Models\Jenis_barang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * This method calculates the grand total of all approved and pending items for the authenticated user,
     * determines the limit based on the user's department, calculates the remaining limit, and then
     * returns the view with these calculated values.
     */
    public function index()
    {
        $grand_total = Barang::where('user_id', Auth::user()->id)->where('status', '<>', 'Ditolak')->sum('sub_total');
        $limit = Limit::where('jurusan_id', Auth::user()->jurusan->id)->sum('limit');
        $sisa = $limit - $grand_total;
        $title = 'Pengajuan Barang';
        return view('dashboard.kkk.barang', compact('title', 'grand_total', 'limit', 'sisa'));
    }

    public function data(Request $request)
    {
        $query = Barang::where('user_id', Auth::user()->id);

        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate)->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->has('status') && $request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $data = $query->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return encrypt($row->id);
                })
                ->addColumn('created_at', function ($q) {
                    return Carbon::parse($q->created_at)->format('H:i') . ', ' . Carbon::parse($q->created_at)->format('d/m/y');
                })
                ->addColumn('harga', function ($q) {
                    return 'Rp ' . number_format($q->harga, 0, ',', '.');
                })
                ->addColumn('status', function ($q) {
                    switch ($q->status) {
                        case 'Disetujui':
                            $q->status = '<span class="badge bg-success">' . $q->status . '</span>';
                            break;
                        case 'Belum disetujui':
                            $q->status = '<span class="badge bg-warning">' . $q->status . '</span>';
                            break;
                        case 'Ditolak':
                            $q->status = '<span class="badge bg-danger">' . $q->status . '</span>';
                            break;
                        default:
                            $q->status = '<span class="badge bg-secondary">' . $q->status . '</span>';
                    }
                    return $q->status;
                })
                ->addColumn('sub_total', function ($q) {
                    return 'Rp ' . number_format($q->sub_total, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    $route_detail = route('pengajuan-barang.show', encrypt($row->id));
                    $route_edit = route('pengajuan-barang.edit', encrypt($row->id));
                    $route_delete = route('pengajuan-barang.destroy', encrypt($row->id));
                    $btn = '';
                    $btn = '<button class="edit btn btn-info btn-sm link-light me-1" data-toggle="tooltip" title="Detail" data-placement="top" data-url="' . $route_detail . '" id="detail"><i class="bi bi-eye"></i></button>';
                    $btn .= '<button class="edit btn btn-warning btn-sm link-light me-1" data-toggle="tooltip" title="Edit" data-placement="top" data-url="' . $route_edit . '" id="ubah"><i class="bi bi-pencil-square"></i></button>';
                    $btn .= '<button class="edit btn btn-danger btn-sm btn-icon" data-toggle="tooltip" title="Delete" data-placement="top" id="hapus" data-url="' . $route_delete . '"><i class="bi bi-trash3"></i></button>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grand_total = Barang::where('user_id', Auth::user()->id)->sum('sub_total');
        $limit = Limit::where('jurusan_id', Auth::user()->jurusan->id)->sum('limit');
        $sisa = $limit - $grand_total;
        return view('dashboard.kkk.create', [
            'title' => 'Ajukan Barang',
            'grand_total' => $grand_total,
            'limit' => $limit,
            'sisa' => $sisa,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'kode_rekening' => 'required',
            'name' => 'required|max:120',
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


        try {
            $harga = str_replace('.', '', $request->harga);
            $subtotal = $harga * $request->stock;
            $expired = $request->expired . '-01';

            $data = $request->all();
            $data['harga'] = $harga;
            $data['sub_total'] = $subtotal;
            $data['expired'] = $expired;
            DB::beginTransaction();

            activity()
                ->causedBy(Auth::user())
                ->performedOn(new Barang())
                ->event('created')
                ->withProperties(['attributes' => [
                    'name' => $data['name'],
                    'harga' => $data['harga'],
                    'stock' => $data['stock'],
                    'spek' => $data['spek'],
                ]])
                ->log('Mengajukan barang');

            Barang::create($data);

            DB::commit();

            return redirect()->route('pengajuan-barang.index')->with('success', 'Berhasil mengajukan barang');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $barang = Barang::where('slug', $slug)->with('anggaran')->first();
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
    public function edit($id)
    {
        $title = 'Edit Barang';
        $barang = Barang::findOrFail(decrypt($id));
        $grand_total = Barang::where('user_id', Auth::user()->id)->sum('sub_total');
        $limit = Limit::where('jurusan_id', Auth::user()->jurusan->id)->sum('limit');
        $sisa = $limit - $grand_total;

        return view('dashboard.kkk.edit', compact('title', 'barang', 'sisa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        try {
            $validate = $request->validate([
                'kode_barang' => 'required',
                'kode_rekening' => 'required',
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

            $validate['sub_total'] = $subtotal;

            DB::beginTransaction();
            activity()->performedOn(new Barang())->event('edited')
                ->withProperties(['old' => [
                    'name' => $barang->name,
                    'harga' => $barang->harga,
                    'stock' => $barang->stock,
                    'spek' => $barang->spek,
                ]])
                ->log('Mengubah data barang');


            $barang->update($validate);
            DB::commit();
            return redirect()->route('pengajuan-barang.index')->with('success', 'Berhasil mengubah data barang');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail(decrypt($id));
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

        return response()->json([
            'status' => 'success',
            'msg' => 'Berhasil menghapus barang.',
        ]);
    }

    public function setuju()
    {
        $title = 'Barang Disetujui';
        return view('dashboard.kkk.setuju', compact('title'));
    }


    public function setujuData(Request $request)
    {
        $userJurusan = Auth::user()->jurusan->slug;
        $query = Barang::query();

        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate)->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $data = $query->where('status', 'Disetujui')->whereHas('jurusan', function ($query) use ($userJurusan) {
            $query->where('slug', $userJurusan);
        })->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return encrypt($row->id);
                })
                ->addColumn('harga', function ($q) {
                    return 'Rp ' . number_format($q->harga, 0, ',', '.');
                })
                ->addColumn('status', function ($q) {
                    return '<span class="badge bg-success">' . $q->status . '</span>';
                })
                ->addColumn('created_at', function ($q) {
                    return Carbon::parse($q->created_at)->format('H:i') . ', ' . Carbon::parse($q->created_at)->format('d/m/y');
                })
                ->rawColumns(['status'])
                ->make(true);
        }
    }

    public function masuk()
    {
        $title = 'Barang Masuk ke ' . Auth::user()->jurusan->name;
        return view('dashboard.kkk.masuk', compact('title'));
    }

    public function masukData(Request $request)
    {
        $query = BarangGudang::where('barang_diambil', '!=', null)
            ->where('jurusan_id', Auth::user()->jurusan->id)
            ->where('jenis_barang', 'Aset')->get();


        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return encrypt($row->id);
                })
                ->addColumn('name', function ($q) {
                    return $q->barang->name;
                })
                ->addColumn('stock_awal', function ($q) {
                    return $q->stock_awal;
                })
                ->addColumn('jumlah_diambil', function ($q) {
                    return $q->stock_awal - $q->stock_akhir;
                })
                ->addColumn('lokasi', function ($q) {
                    return $q->lokasi;
                })
                ->addColumn('penerima', function ($q) {
                    return $q->penerima;
                })
                ->make(true);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'mimes:xlsx,csv'
        ]);

        $file = $request->file('file');
        try {
            Excel::import(new PengajuanImport, $file);
            return redirect()->back()->with('success', 'Data berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data.')->withErrors($failures);
        }
    }
}

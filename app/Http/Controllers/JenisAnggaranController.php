<?php

namespace App\Http\Controllers;

use App\Models\Jenis_anggaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JenisAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kelola Jenis Anggaran';
        return view('dashboard.admingaran.jenis_anggaran', compact('title'));
    }

    /**
     * Return data for datatables
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = Jenis_anggaran::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('H:i') . ' WIB, ' . Carbon::parse($row->created_at)->translatedFormat('d M Y');
                })
                ->addColumn('action', function ($row) {
                    $route_edit = route('data-master.jenis-anggaran.update', encrypt($row->id));
                    $route_delete = route('data-master.jenis-anggaran.destroy', encrypt($row->id));
                    $btn = '';
                    $btn .= '<button class="edit btn btn-warning btn-sm link-light me-1" data-toggle="tooltip" title="Edit" data-placement="top" data-url="' . $route_edit . '" id="ubah"><i class="bi bi-pencil-square"></i></button>';
                    $btn .= '<button class="edit btn btn-danger btn-sm btn-icon" data-toggle="tooltip" title="Hapus" data-placement="top" id="hapus" data-url="' . $route_delete . '"><i class="bi bi-trash3"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
        try {
            $request->validate([
                'name' => 'required|string',
                'tahun' => 'required',
            ]);

            DB::beginTransaction();
            Jenis_anggaran::create([
                'name' => $request->name,
                'tahun' => $request->tahun,
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'msg' => 'Berhasil menambahkan jenis anggaran.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jenis_anggaran $jenis_anggaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenis_anggaran $jenis_anggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jenis_anggaran $jenis_anggaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $decryptedId = decrypt($id);
        $data = Jenis_anggaran::findOrFail($decryptedId);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'msg' => 'Berhasil menghapus jenis anggaran.',
        ]);
    }
}

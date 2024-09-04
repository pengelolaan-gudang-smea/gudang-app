<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kelola Jurusan';
        return view('dashboard.admingaran.jurusan', compact('title'));
    }

    public function data(Request $request)
    {
        $data = Jurusan::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('H:i') . ' WIB, ' . Carbon::parse($row->created_at)->translatedFormat('d M Y');
                })
                ->addColumn('action', function ($row) {
                    $route_edit = route('data-master.jurusan.update', $row->slug);
                    $route_delete = route('data-master.jurusan.destroy', $row->slug);
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
            $data = $request->validate([
                'name' => 'required',
            ]);

            DB::beginTransaction();
            Jurusan::create($data);
            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Berhasil menambah jurusan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        try {
            $data = $request->validate([
                'name' => 'required',
            ]);

            DB::beginTransaction();
            $jurusan = Jurusan::where('slug', $slug)->first();
            $jurusan->update($data);
            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah jurusan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        try {
            DB::beginTransaction();
            $jurusan->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Berhasil menghapus jurusan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }
}

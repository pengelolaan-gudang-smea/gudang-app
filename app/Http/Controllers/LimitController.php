<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Jurusan;
use App\Models\Limit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Limit Anggaran';
        return view('dashboard.waka.limit.limit', compact('title'));
    }

    public function data(Request $request)
    {
        $data = Limit::orderByDesc('id')->with('anggaran', 'jurusan')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('limit', function ($q) {
                    return 'Rp ' . number_format($q->limit, 0, ',', '.');
                })
                ->addColumn('jurusan', function ($q) {
                    return $q->jurusan->name;
                })
                ->addColumn('jenis_anggaran', function ($q) {
                    return $q->anggaran->jenis_anggaran;
                })
                ->addColumn('tahun', function ($q) {
                    return $q->anggaran->tahun;
                })
                ->addColumn('action', function ($row) {
                    $route_edit = route('limit-anggaran.edit', encrypt($row->id));
                    $route_delete = route('limit-anggaran.destroy', encrypt($row->id));
                    $btn = '';
                    $btn .= '<button class="edit btn btn-warning btn-sm link-light me-1" data-toggle="tooltip" title="Edit" data-placement="top" data-url="' . $route_edit . '" id="ubah"><i class="bi bi-pencil-square"></i></button>';
                    $btn .= '<button class="edit btn btn-danger btn-sm btn-icon" data-toggle="tooltip" title="Delete" data-placement="top" id="hapus" data-url="' . $route_delete . '"><i class="bi bi-trash3"></i></button>';
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
        if ($request->jurusan_id === 'all') {
            $jurusans = Jurusan::all();

            foreach ($jurusans as $jurusan) {
                $limit = new Limit();
                $limit->limit = str_replace('.', '', $request->limit);
                $limit->jurusan_id = $jurusan->id;
                $limit->anggaran_id = $request->anggaran_id;
                $limit->save();
            }
        } else {
        $limit = new Limit();
        $limit->limit = str_replace('.', '', $request->limit);
        $limit->jurusan_id = $request->jurusan_id;
        $limit->anggaran_id = $request->anggaran_id;
            $limit->save();
        }
        return redirect()->route('limit-anggaran.index')->with('success', 'Behasil mengatur limit anggaran');
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
    public function edit($id)
    {
        $decryptedId = decrypt($id);
        $limit = Limit::findOrFail($decryptedId);
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
        $limit->limit = str_replace('.', '', $request->limit);
        $limit->anggaran_id = $request->anggaran_id;
        $limit->jurusan_id = $request->jurusan_id;
        $limit->update();
        return redirect()->route('limit-anggaran.index')->with('success','Berhasil merubah limit anggaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $decryptedId = decrypt($id);
        $limit = Limit::findOrFail($decryptedId);
        $limit->delete();
        return response()->json([
            'status' => 'success',
            'msg' => 'Berhasil menghapus limit anggaran',
        ]);
    }
}

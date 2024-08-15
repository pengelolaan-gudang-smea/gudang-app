<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Barang;
use App\Models\Jenis_anggaran;
use App\Models\Jurusan;
use App\Models\Limit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.waka.anggaran.anggaran', [
            'title' => 'List Anggaran',
            'anggaran' => Anggaran::all()
        ]);
    }

    public function data(Request $request)
    {
        $data = Anggaran::orderByDesc('id')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return encrypt($row->id);
                })
                ->addColumn('anggaran', function($row) {
                    return 'Rp ' . number_format($row->anggaran, 0, ',', '.');
                })
                ->addColumn('created_at', function($row) {
                    return Carbon::parse($row->created_at)->format('H:i') . ' WIB, ' . Carbon::parse($row->created_at)->format('d M Y');
                })
                ->addColumn('action', function ($row) {
                    $route_edit = route('anggaran.edit', encrypt($row->id));
                    $route_delete = route('anggaran.destroy', encrypt($row->id));
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
        return view('dashboard.waka.anggaran.create', [
            'title' => 'Tambah Anggaran',
            'jenis_anggaran' => Jenis_anggaran::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'anggaran' => ['required'],
            'jenis_anggaran' => 'required',
            'tahun' => 'required',
        ]);

        activity()
        ->causedBy(Auth::user())
        ->performedOn(new Anggaran())->event('created')
        ->log('Menambahkan anggaran');

        $anggaran = new Anggaran();
        $anggaran->anggaran = str_replace('.', '', $validate['anggaran']);
        $anggaran->jenis_anggaran = $validate['jenis_anggaran'];
        $anggaran->tahun = $validate['tahun'];
        $anggaran->save();

        return redirect()->route('anggaran.index')->with('success', 'Berhasil menambahkan anggaran');
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
        $title = 'Edit Anggaran';
        $decryptedId = decrypt($id);
        $anggaran = Anggaran::findOrFail($decryptedId);

        return view('dashboard.waka.anggaran.edit', compact('title', 'anggaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggaran $anggaran)
    {
        $validate = $request->validate([
            'anggaran' => ['required'],
            'jenis' => 'required',
            'tahun' => 'required',
        ]);

        $anggaran->anggaran = str_replace('.', '', $validate['anggaran']);
        $anggaran->jenis_anggaran = $validate['jenis'];
        $anggaran->tahun = $validate['tahun'];
        $anggaran->update();

        return redirect()->route('anggaran.index')->with('success', 'Berhasil mengubah data anggaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $decryptedId = decrypt($id);
        $anggaran = Anggaran::findOrFail($decryptedId);
        $anggaran->delete();

        return response()->json([
            'status' => 'success',
            'msg' => 'Berhasil menghapus anggaran.',
        ]);
    }

    public function checkAnggaran($id)
    {
        $limit = Limit::where('anggaran_id', $id)->sum('limit');
        $anggaran = Anggaran::where('id',$id)->value('anggaran');
        if ($limit > 0) {
            $total = $anggaran - $limit;
        }else{
            $total = Anggaran::where('id', $id)->value('anggaran');
        }

        if($total <= 0){
            return response()->json(['status'=>'limit reach']);
        }

        return response()->json($total);
    }
}

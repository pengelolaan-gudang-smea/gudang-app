<?php

namespace App\Http\Controllers;

use App\Exports\BarangAccExport;
use App\Models\Anggaran;
use Carbon\Carbon;
use App\Models\Barang;
use App\Models\BarangGudang;
use App\Models\Jurusan;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminAngaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.admingaran.anggaran', [
            'title' => 'Barang diajukan',
            'barang' => Barang::all(),
            'anggaran' => Anggaran::all()
        ]);
    }

    public function data(Request $request)
    {
        $barang = Barang::with('anggaran')
                            ->when($request->jurusan && $request->jurusan !== 'all', function($query) use ($request) {
                                $query->where('jurusan_id', $request->jurusan);
                            })
                            ->when($request->tahun && $request->tahun !== 'all', function($query) use ($request) {
                                $query->whereYear('created_at', $request->tahun);
                            })
                            ->get();

        if ($request->ajax()) {
            return DataTables::of($barang)
                ->addIndexColumn()
                ->addColumn('id', function ($q) {
                    return encrypt($q->id);
                })
                ->addColumn('created_at', function ($q) {
                    return Carbon::parse($q->created_at)->format('H:i') . ', ' . Carbon::parse($q->created_at)->format('d M Y');
                })
                ->addColumn('harga', function ($q) {
                    return 'Rp ' . number_format($q->harga, 0, ',', '.');
                })
                ->addColumn('status', function ($q) {

                    $originalStatus = $q->status;
                    $statusWithBadge = '';

                    switch ($q->status) {
                        case 'Disetujui':
                            $statusWithBadge = '<span class="badge bg-success">' . $originalStatus . '</span>';
                            break;
                        case 'Belum disetujui':
                            $statusWithBadge = '<span class="badge bg-warning">' . $originalStatus . '</span>';
                            break;
                        case 'Ditolak':
                            $statusWithBadge = '<span class="badge bg-danger">' . $originalStatus . '</span>';
                            break;
                        default:
                            $statusWithBadge = '<span class="badge bg-secondary">' . $originalStatus . '</span>';
                    }

                    $q->status_with_badge = $statusWithBadge;

                    $q->original_status = $originalStatus;
                    return $q->status_with_badge;
                })
                ->addColumn('original_status', function ($q) {
                    return $q->original_status;
                })
                ->addColumn('keterangan_with_badge', function ($q) {

                    $keteranganWithBadge = '';

                    switch ($q->status) {
                        case 'Disetujui':
                            $keteranganWithBadge = '<span class="badge bg-success">' . $q->keterangan . ' barang disetujui' . '</span>';
                            break;
                        case 'Belum disetujui':
                            $keteranganWithBadge = '<span class="badge bg-warning">' . $q->status . '</span>';
                            break;
                        default:
                            $keteranganWithBadge = '<span class="badge bg-secondary">' . $q->keterangan . '</span>';
                    }

                    $q->keterangan_with_badge = $keteranganWithBadge;

                    return $q->keterangan_with_badge;
                })
                ->addColumn('sub_total', function ($q) {
                    return 'Rp ' . number_format($q->sub_total, 0, ',', '.');
                })
                ->addColumn('action', function ($q) {
                    $route_detail = route('barang-acc.show', encrypt($q->id));
                    $route_edit = route('persetujuan.editBarang', $q->slug);
                    $route_acc = route('barang-acc.update', $q->slug);
                    $route_reject = route('barang-acc.update', $q->slug);
                    $btn = '';
                    // Button "Detail" selalu ditampilkan
                    $btn .= '<button class="edit btn btn-info btn-sm link-light me-1" data-toggle="tooltip" title="Detail" data-placement="top" data-url="' . $route_detail . '" id="detail"><i class="bi bi-eye"></i></button>';

                    if ($q->original_status == 'Belum disetujui') {
                        $btn .= '<button class="edit btn btn-success btn-sm link-light me-1" data-toggle="tooltip" title="Setujui" data-placement="top" data-url="' . $route_acc . '" id="acc"><i class="bi bi-check2"></i></button>';
                        $btn .= '<button class="edit btn btn-danger btn-sm btn-icon" data-toggle="tooltip" title="Tolak" data-placement="top" id="reject" data-url="' . $route_reject . '" id="acc"><i class="bi bi-x"></i></button>';
                    } elseif ($q->original_status == 'Disetujui') {
                        $btn .= '<button class="edit btn btn-warning btn-sm link-light me-1" data-toggle="tooltip" title="Edit barang disetujui" data-placement="top" data-url="' . $route_edit . '" id="ubah"><i class="bi bi-pencil-square"></i></button>';
                        $btn .= '<button class="edit btn btn-danger btn-sm btn-icon" data-toggle="tooltip" title="Tolak" data-placement="top" id="reject" data-url="' . $route_reject . '"><i class="bi bi-x"></i></button>';
                    } elseif ($q->original_status == 'Ditolak') {
                        $btn .= '<button class="edit btn btn-success btn-sm link-light me-1" data-toggle="tooltip" title="Setujui" data-placement="top" data-url="' . $route_acc . '" id="acc"><i class="bi bi-check2"></i></button>';
                    }

                    return $btn;
                })
                ->rawColumns(['status', 'keterangan_with_badge', 'action'])
                ->make(true);
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
    public function edit(Barang $acc)
    {
        return view('dashboard.admingaran.edit', [
            'title' => 'Edit Barang',
            'barang' => $acc
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $acc)
    {
        try {
            if ($request->ajax() && $request->has('persetujuan')) {

                // ? Update Barang jika di setujui
                $validated = $request->validate([
                    'persetujuan' => 'required',
                    'jenis_anggaran' => 'required'
                ]);

                $validated['persetujuan'] = $request->input('persetujuan');
                $validated['jenis_anggaran'] = $request->input('jenis_anggaran');
                $acc->update([
                    'status' => 'Disetujui',
                    'keterangan' => $validated['persetujuan'],
                    'anggaran_id' => $validated['jenis_anggaran']
                ]);

                // ? Masukan Barang yang sudah disetujui ke Barang_Gudang

                $barangGudang = BarangGudang::where('kode_barang', $acc->kode_barang)->get();
                if ($barangGudang->isNotEmpty()) {
                    foreach ($barangGudang as $barang_gudang) {
                        $barang_gudang->increment('stock_awal', $request->input('persetujuan'));
                        $barang_gudang->increment('stock_akhir', $request->input('persetujuan'));
                    }
                } else {
                    BarangGudang::create([
                        'name' => $acc->name,
                        'kode_barang'=> $acc->kode_barang,
                        'kode_rekening'=> $acc->kode_rekening,
                        'spek' => $acc->spek,
                        'no_inventaris' => $acc->no_inventaris,
                        'slug' => $acc->slug,
                        'stock_awal' => $request->input('persetujuan'),
                        'stock_akhir' => $request->input('persetujuan'),
                        'barang_id' => $acc->id,
                        'tahun' => Carbon::now()->year,
                        'satuan' => $acc->satuan,
                        'tujuan' => $acc->tujuan,
                        'jenis_barang' => $acc->jenis_barang,
                        'anggaran_id' => $acc->anggaran_id,
                        'jurusan_id' => $acc->jurusan_id,
                    ]);
                }

                // ? Set Activity
                activity()->performedOn(new Barang())->event('accepted')
                    ->withProperties(['attributes' => [
                        'name' => $acc->name,
                        'harga' => $acc->harga,
                        'satuan' => $acc->satuan,
                        'spek' => $acc->spek,
                    ]])
                    ->log('Menyetujui barang yang diajukan oleh ' . $acc->user->username);
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Berhasil menyetujui barang ' . $acc->no_inventaris,
                ]);
            } elseif ($request->has('penolakan')) {
                // ? Set Activity
                activity()->performedOn(new Barang())->event('rejected')
                    ->withProperties(['attributes' => [
                        'name' => $acc->name,
                        'harga' => $acc->harga,
                        'satuan' => $acc->satuan,
                        'spek' => $acc->spek,
                    ]])->log('Menolak barang yang diajukan oleh ' . $acc->user->username);

                // ? Update Barang jika status ditolak
                $acc->update([
                    'status' => 'Ditolak',
                    'keterangan' => $request->input('penolakan')
                ]);
                $message = 'Ditolak';

                // ? Kurangi stock barang gudang sesuai jumlah yang di setujui
                $barang = BarangGudang::where('barang_id', $acc->id)->first();
                $barangGudang = BarangGudang::where('name', $acc->name)->where('jenis_barang', $acc->jenis_barang)->get();
                foreach ($barangGudang as $barang_gudang) {
                    $barang_gudang->decrement('stock_akhir', $acc->stock);
                }
                if ($barang) {
                    $barang->delete();
                }

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Berhasil menolak barang ' . $acc->no_inventaris,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ]);
        }
    }


    public function EditBarangPersetujuan(Request $request, $slug)
    {
        $barang_update = Barang::where('slug', $slug)->first();
        $barang_gudang = BarangGudang::where('slug', $slug)->first();

        $barang_update->update([
            'keterangan' => $request->jumlah,
            'anggaran_id' => $request->jenis_anggaran
        ]);

        $barang_gudang->update([
            'stock' => $request->jumlah,
            'anggaran_id' => $request->jenis_anggaran,
        ]);

        return response()->json([
            'status' => 'success',
            'msg' => 'Berhasil mengubah jumlah barang yang disetujui.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $acc) {}

    public function getTahunByJurusan(Request $request)
    {
        $tahun = Barang::where('jurusan_id', $request->jurusan_id)
                ->selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->pluck('year');

        return response()->json($tahun);
    }

    public function exportPdf(Request $request)
    {
        $filename = "laporan_pengajuan_barang_" . date("Y-m-d") . ".pdf";
        $jurusanId = $request->jurusan;
        $tahun = $request->tahun;

        $query = Barang::query();

        // Handling jurusan filter
        $jurusanName = 'Semua Jurusan';
        if ($jurusanId !== null && $jurusanId !== 'all' && $jurusanId !== 'null') {
            $jurusan = Jurusan::find($jurusanId);
            if ($jurusan) {
                $jurusanName = $jurusan->name;
            }
        }

        // Handling tahun filter
        $tahunName = 'Semua Tahun';
        if ($tahun !== null && $tahun !== 'all' && $tahun !== 'null') {
            $tahunName = $tahun;
        }

        // Applying filters
        if ($jurusanId !== null && $jurusanId !== 'all' && $jurusanId !== 'null') {
            $query->where('jurusan_id', $jurusanId);
        }

        if ($tahun !== null && $tahun !== 'all' && $tahun !== 'null') {
            $query->whereYear('created_at', $tahun);
        }

        $data = $query->get();

        $view = view('dashboard.admingaran.export_pdf', [
            'data' => $data,
            'heading' => "Laporan Pengajuan Barang oleh Admin Anggaran", // heading
            'date' => Carbon::now()->locale('id')->isoFormat('D MMMM Y, hh:mm:ss') . ' WIB',
            'jurusan' => $jurusanName,
            'tahun' => $tahunName,
        ])->render();

        // instance Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // load view into dompdf
        $dompdf->loadHtml($view);

        // setup paper and orientation
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream($filename);
    }

    public function exportExcel(Request $request)
    {
        $jurusanId = $request->jurusan;
        $tahun = $request->tahun;

        $filename = "laporan_pengajuan_barang_" . date("Y-m-d") . ".xlsx";
        return Excel::download(new BarangAccExport($jurusanId, $tahun), $filename);
    }
}

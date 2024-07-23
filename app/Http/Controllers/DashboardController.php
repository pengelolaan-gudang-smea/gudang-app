<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Barang;
use App\Models\BarangGudang;
use App\Models\Jurusan;
use App\Models\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        // dd(auth()->user()->roles->first()->name);
        $userCount = User::all()->count();
        $roleCount = Role::all()->count();
        $jurusanCount = Jurusan::all()->count();

        $barangKKK = 0;
        $anggaranKKK = 0;
        if (Auth::user()->jurusan) {
            $barangKKK = Barang::where('user_id', Auth::user()->id)->get()->count();
            $anggaranKKK = Limit::where('jurusan_id', Auth::user()->jurusan->id)->sum('limit');
        }

        $barang = Barang::all()->count();
        $barangGudang = BarangGudang::all()->count();

        return view('dashboard.index', [
            'title' => 'Overview',
            'userCount' => $userCount,
            'roleCount' => $roleCount,
            'jurusanCount' => $jurusanCount,
            'barangCount' => $barangKKK,
            'anggaranCount' => $anggaranKKK,
            'barang' => $barang,
            'barangGudang' => $barangGudang,
        ]);
    }

    public function chartBarang()
    {
        $endDate = now();
        $startDate = $endDate->copy()->subDays(6);
        $userRole = auth()->user()->roles->first()->name;

        $data = [];

        switch ($userRole) {
            case 'WAKA':
                $data = $this->getDataforWaka($startDate, $endDate);
                break;
            case 'KKK':
                $data = $this->getDataForKKK($startDate, $endDate);
                break;
            case 'Admin anggaran':
                $data = $this->getDataForAdminAnggaran($startDate, $endDate);
                break;
            case 'Admin gudang ':
                $data = $this->getDataForAdminGudang($startDate, $endDate);

                break;
        }

        return response()->json($data);
    }

    private function getDataforWaka($startDate, $endDate)
    {
        $data = DB::table('rekap_login')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();

        return $this->formatData($data, $startDate, $endDate);
    }

    private function getDataForKKK($startDate, $endDate)
    {
        $userId = auth()->user()->id;

        $data = DB::table('barang')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('user_id', $userId)
            ->groupBy('date')
            ->get();

        return $this->formatData($data, $startDate, $endDate);
    }

    private function getDataForAdminAnggaran($startDate, $endDate)
    {
        $data = DB::table('barang')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();

        return $this->formatData($data, $startDate, $endDate);
    }

    private function getDataForAdminGudang($startDate, $endDate)
    {
        $data = DB::table('activity_log')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('description', 'Barang diambil oleh petugas lapangan  ')
            ->groupBy('date')
            ->get();

        return $this->formatData($data, $startDate, $endDate);
    }

    private function formatData($data, $startDate, $endDate)
    {
        $weeklyData = [];
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('j M Y');
            $totalBarang = $data->firstWhere('date', $currentDate->toDateString())->total ?? 0;
            $weeklyData[] = [
                'date' => $formattedDate,
                'total_barang' => $totalBarang,
            ];
            $currentDate->addDay();
        }

        return $weeklyData;
    }
}

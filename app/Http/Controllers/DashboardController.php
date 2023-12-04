<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Barang;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $userCount = User::all()->count();
        $roleCount = Role::all()->count();
        $jurusanCount = Jurusan::all()->count();
        return view('dashboard.index', [
            'title' => 'Overview',
            'userCount' => $userCount,
            'roleCount' => $roleCount,
            'jurusanCount' => $jurusanCount,
        ]);
    }

    public function chartBarang()
    {
        $endDate = now();
        $startDate = $endDate->copy()->subDays(6);

        $data = DB::table('barang')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();

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

        return response()->json($weeklyData);
    }

}

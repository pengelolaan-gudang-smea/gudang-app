<?php

namespace App\Http\Controllers;

use App\Models\RekapLogin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class RekapController extends Controller
{
    public function rekapLogin() {
        $title = 'Rekap Aktivitas Login';
        return view('dashboard.waka.rekap.rekap_login', compact('title'));
    }

    public function dataRekapLogin(Request $request) {
        $query = RekapLogin::query();

        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate)->endOfDay();

            $query->whereBetween('login', [$startDate, $endDate]);
        }

        $login = $query->latest()->get();

        if ($request->ajax()) {
            return DataTables::of($login)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->user->name;
                })
                ->addColumn('username', function($row){
                    return $row->user->username;
                })
                ->addColumn('login', function($row){
                    return Carbon::parse($row->login)->format('H:i') . ' WIB, ' . Carbon::parse($row->login)->translatedFormat('d M Y');
                })
                ->addColumn('logout', function($row){
                    return $row->logout ? Carbon::parse($row->logout)->format('H:i') . ' WIB, ' . Carbon::parse($row->logout)->translatedFormat('d M Y') : '-';
                })
                ->make(true);
        }
    }

    public function rekapActivity(){
        $title = 'Rekap Aktivitas';
        return view('dashboard.waka.rekap.rekap_activity',compact('title'));
    }

    public function dataRekapActivity(Request $request)
    {

        if ($request->ajax()) {
            return DataTables::of(Activity::latest()->get())
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return optional($row->causer)->name ? $row->causer->name : '-';
                })
                ->addColumn('created_at', function($row){
                    return Carbon::parse($row->created_at)->format('H:i') . ' WIB, ' . Carbon::parse($row->created_at)->translatedFormat('d M Y');
                })
                ->make(true);
        }
    }
}

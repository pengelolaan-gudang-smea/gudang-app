<?php

namespace App\Http\Controllers;

use App\Models\RekapLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class RekapController extends Controller
{
    public function rekapLogin() {
        return view('dashboard.waka.rekap.rekap_login',[
            'title'=>'Rekap Login',
            'login'=>RekapLogin::latest()->get()
        ]);
    }

    public function filterDate(Request $req)
    {
        $title = 'Rekap Login';
        $start_date = $req->start_date;
        $end_date = $req->end_date;

        $login = RekapLogin::whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date)
                            ->get();
        return view('dashboard.waka.rekap.rekap_login', compact('login', 'title'));
    }

    public function rekapActivity(){
       $activity = Activity::latest()->get();
        return view('dashboard.waka.rekap.rekap_activity',[
            'title'=>'Rekap Aktivitas',
            'activity'=>$activity
        ]);
    }
}

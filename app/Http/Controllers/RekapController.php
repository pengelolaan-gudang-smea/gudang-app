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

    public function rekapActivity(){
       $activity = Activity::latest()->get();
        return view('dashboard.waka.rekap.rekap_activity',[
            'title'=>'Rekap Aktivitas',
            'activity'=>Activity::latest()->get()
        ]);
    }
}

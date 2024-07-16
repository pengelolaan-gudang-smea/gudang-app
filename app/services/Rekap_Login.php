<?php

namespace App\Services;

use App\Models\RekapLogin;
use App\Models\User;
use Carbon\Carbon;

class Rekap_Login
{
    public static function login($user)
    {
        RekapLogin::create([
            'user_id' => $user,
            'login' => Carbon::now()
        ]);
    }

    // public static function logout($user)
    // {
    //     $userId = RekapLogin::where('user_id', $user)->whereNull('logout')->latest('login')->first();

    //     $userId->update([
    //         'logout' => Carbon::now()
    //     ]);
    // }
}

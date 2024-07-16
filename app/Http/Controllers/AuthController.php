<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Rekap_Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // * Login & logout

    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function auth(Request $request)
    {
        $validate = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);
        if (Auth::attempt($validate)) {
            $request->session()->regenerate();
            Rekap_Login::login(Auth::user()->id);
            return redirect()->route('dashboard');
        } else {
            return back()->with('error', 'Periksa username dan password');
        }
    }

    public function logout(Request $request)
    {
        // Rekap_Login::logout(Auth::user()->id);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

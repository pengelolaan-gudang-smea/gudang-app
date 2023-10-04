<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            return redirect()->route('dashboard');
        } else {
            return back()->with('error', 'Periksa username dan password');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // * register

    public function register()
    {
        return view('auth.register', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'email' => ['email', 'required', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return redirect()->route('login')->with('success', 'Register berhasil, silahkan login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.profile.index', [
            'title' => 'Profile ' . Auth::user()->username
        ]);
    }
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'username' => 'required',
            'email' => 'required',
        ]);
        $user->update($validate);
        return back()->with('success', 'Berhasil mengubah profile');
    }

    public function change(Request $request, User $user)
    {
        $request->validate([
            'current_password' => 'required|min:8',
        ]);

        $inputPassword = $request->input('current_password');
        $storedPassword = $user->password;

        if (Hash::check($inputPassword, $storedPassword)) {
            return 'cocok';
        }
    }
}

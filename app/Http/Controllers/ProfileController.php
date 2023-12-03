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
            'name'=>['required'],
            'username' => ['required','unique:users,username,'. $user->id],
            'email' => ['required','email','unique:users,email,'. $user->id],
        ]);
        activity()->performedOn(new User())->event('edited')
        ->withProperties([
            'old' => [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
            ]
        ])
        ->log('Mengubah profile ');
        $user->update($validate);
        return redirect()->route('dashboard.profile',['user'=>Auth::user()->username])->with('success', 'Berhasil mengubah profile');
    }

    public function changePass(Request $request, User $user)
    {
        $old_pass = $request->current_password;

        if (Hash::check($old_pass, $user->password)) {
            $pass = $request->validate([
                'new_password' => ['min:8', 'confirmed']
            ]);
            $password_hash = Hash::make($pass['new_password']);
            $user->update(['password' => $password_hash]);
            // dd('berhasil');
            return back()->with('success', 'Berhasil merubah password');
        } else {
            return back()->withInput()->withErrors(['current_password' => 'Password lama tidak cocok']);
        }
    }
}

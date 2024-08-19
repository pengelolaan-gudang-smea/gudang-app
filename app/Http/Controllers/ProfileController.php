<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.profile.index', [
            'title' => 'Profile ' . Auth::user()->username,
            'tab' => 'profile_overview'
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
        return redirect()->route('dashboard.profile',['user'=>Auth::user()->username])->with([
            'success' => 'Berhasil mengubah profile',
            'tab' => 'profile_edit'
        ]);
    }

    public function changePass(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed']
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'profile_change_password');
        }

        if (Hash::check($request->current_password, $user->password)) {
            dd($user->password);
            $password_hash = Hash::make($request->new_password);
            $user->update(['password' => $password_hash]);
            return back()->with([
                'success' => 'Berhasil merubah password',
                'tab' => 'profile_change_password'
            ]);
        } else {
            return back()->withErrors([
                'current_password' => 'Password lama tidak cocok'
            ])->withInput()->with('tab', 'profile_change_password');
        }
    }
}

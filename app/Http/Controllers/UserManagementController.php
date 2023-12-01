<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.waka.users.user', [
            'title' => 'User Management',
            'user' =>  User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'WAKA'); // Ganti 'WAKA' dengan nama peran yang ingin Anda kecualikan
            })->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.waka.users.create', [
            'title' => 'Tambah User',
            'hak' => Permission::all(),
            'roles' => Role::all(),
            'jurusan'=>Jurusan::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required', 'min:8'],
            'jurusan_id'=>'nullable',
        ]);
        // dd($validate);
        $role = $request->input('role');
        $akses = $request->input('akses');

        $user = User::create($validate);
        $user->assignRole($role);
        $user->givepermissionTo($akses);
        return redirect()->route('user.index')->with('success', 'Berhasil menambahkan user');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $role = $user->roles()->first();
        $akses = $user->permissions()->get();

        return view('dashboard.waka.users.akses', [
            'title' => 'Akses User',
            'user' => $user,
            'role' => $role,
            'hak' => Permission::with('roles')->get(),
            'akses' => $akses,
        ]);
    }

    public function akses(Request $request, User $user)
    {
        // Ambil hak akses yang dicentang
        $permissionsToAssign = $request->input('akses', []);

        // Hapus hak akses yang tidak dicentang
        $permissionsToRemove = $user->permissions()
            ->whereNotIn('id', $permissionsToAssign)
            ->get();

        foreach ($permissionsToRemove as $permission) {
            $user->revokePermissionTo($permission);
        }

        // Berikan hak akses yang dicentang
        $user->givePermissionTo($permissionsToAssign);

        return redirect()->route('user.index')->with('success', 'Berhasil merubah hak akses');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // $id = $user->roles->first()->id;
        // dd($user->roles);
        $akses = $user->permissions()->get();
        return view('dashboard.waka.users.edit', [
            'title' => 'Edit ' . $user->username,
            'user' => $user,
            'roles' => Role::all(),
            'hak' => Permission::all(),
            'jurusan'=>Jurusan::all(),
            'akses' => $akses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $role = $request->input('roles');
        $role_old = $user->roles->first()->id;

        $validateRules = [
            'name' => 'required' . $user->id,
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        $validate = $request->validate($validateRules);

        if ($request->has('password')) {
            $validateRules['password'] = ['required', 'min:8'];
            $validate['password'] = Hash::make($request->input('password'));
        }

        if ($role !== $role_old) {
            $user->removeRole($role_old);
            $user->assignRole($role);
        }
        if($request->jurusan_id){
            $user->jurusan_id = $request->input('jurusan_id');
        }

        $user->update($validate);

        return redirect()->route('user.index')->with('success', 'Berhasil merubah data ' . $user->username);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $role = $user->roles->first()->id;

        $user->permissions()->detach();

        $user->removeRole($role);

        $user->delete();

        return redirect()->route('user.index')->with('success', 'Berhasil menghapus pengguna');
    }
}

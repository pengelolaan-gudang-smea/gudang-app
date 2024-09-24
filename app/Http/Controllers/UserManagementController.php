<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'User Management';
        return view('dashboard.waka.users.user', compact('title'));
        // 'user' =>  User::whereDoesntHave('roles', function ($query) {
        //     $query->where('name', 'WAKA');
        // })->get()
    }

    public function data(Request $request)
    {
        $users = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'WAKA');
        })->get();

        if ($request->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return encrypt($row->id);
                })
                ->addColumn('role', function ($row) {
                    $role = $row->roles->first()->name;
                    $data = $role !== 'KKK' ? $row->roles->pluck('name')->implode(', ') : $row->roles->pluck('name')->implode(', ') . ' - ' . $row->jurusan->name;
                    return $data;
                })
                ->addColumn('action', function ($row) {
                    $route_detail = route('user.show', $row->username);
                    $route_edit = route('user.edit', $row->username);
                    $route_delete = route('user.destroy', $row->username);
                    $btn = '';
                    $btn = '<button class="edit btn btn-info btn-sm link-light me-1" data-toggle="tooltip" title="Detail" data-placement="top" data-url="' . $route_detail . '" id="detail"><i class="bi bi-universal-access"></i></button>';
                    $btn .= '<button class="edit btn btn-warning btn-sm link-light me-1" data-toggle="tooltip" title="Edit" data-placement="top" data-url="' . $route_edit . '" id="ubah"><i class="bi bi-pencil-square"></i></button>';
                    $btn .= '<button class="edit btn btn-danger btn-sm btn-icon" data-toggle="tooltip" title="Delete" data-placement="top" id="hapus" data-url="' . $route_delete . '"><i class="bi bi-trash3"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
            'jurusan' => Jurusan::all()
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
            'jurusan_id' => 'nullable',
        ]);
        // dd($validate);
        $role = $request->input('role');
        $akses = $request->input('akses');


        activity()->performedOn(new User())->event('created')
            ->withProperties(['attributes' => [
                'name' => $validate['name'],
                'username' => $validate['username'],
                'email' => $validate['email'],
            ]])
            ->log('Menambahkan user');
            // dd($validate);
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

        $hakAkses = [];
        $aksesUser = $user->permissions()->get();

        foreach ($aksesUser as $akses) {
            $hakAkses[] = $akses->name;
        }
        // dd($hakAkses);
        activity()->performedOn(new User())->event('edited')
            ->withProperties([
                'old' => [
                    "hak akses" => $hakAkses
                ]
            ])
            ->log('Mengubah hak akses user');
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
            'jurusan' => Jurusan::all(),
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

        if ($request->input('password') != $user->pasword) {
            $validateRules['password'] = ['required', 'min:8'];
            $validate['password'] = Hash::make($request->input('password'));
        }

        if ($role !== $role_old) {
            $user->removeRole($role_old);
            $user->assignRole($role);
        }
        if ($request->jurusan_id) {
            $user->jurusan_id = $request->input('jurusan_id');
        }

        activity()->performedOn(new User())->event('edited')
            ->withProperties([
                'old' => [
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                ]
            ])
            ->log('Mengubah data user');

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
        activity()->performedOn(new User())->event('deleted')
            ->withProperties([
                'old' => [
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                ]
            ])
            ->log('Menghapus user');

        $user->delete();

        return response()->json([
            'status' => 'success',
            'msg' => 'Berhasil menghapus user.',
        ]);
    }
}

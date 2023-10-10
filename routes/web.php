<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserManagementController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// * Authenticate
Route::controller(AuthController::class)->group(function () {
    // * Login & Logout
    Route::get('/', 'index')->name('login');
    Route::post('/login', 'auth')->name('login.auth');
    Route::post('/logout', 'logout')->name('logout');
});

// * forgot & reset password
Route::controller(PasswordController::class)->group(function () {
    Route::get('/forgot-pasword', 'index')->name('forgot.password');
    Route::post('/forgot-password', 'forgot')->name('password.email');

    Route::get('/reset-password/{token}', 'reset')->name('password.reset');
    Route::post('/reset-password', 'update')->name('password.update');
});


// * Dashboard
Route::middleware('auth')->prefix('/dashboard')->group(function () {
    Route::get('', DashboardController::class)->name('dashboard');

    Route::get('/profile/{user:username}', function (User $user) {
        return view('dashboard.profile.index', [
            'title' => 'Profile | ' . $user->username
        ]);
    })->name('dashboard.profile');

    //  * WAKA
    Route::middleware('can:Edit akun')->group(function () {
        Route::resource('/user', UserManagementController::class);
        Route::post('/hak-akses/{user:username}', [UserManagementController::class, 'akses'])->name('user.akses');
    });

    // * KKK
    Route::resource('/pengajuan-barang', BarangController::class)->parameters(['pengajuan-barang' => 'barang'])->middleware('can:Mengajukan barang');
    Route::get('/barang-disetujui', [BarangController::class, 'setuju'])->name('barang.setuju');

    // * Admin Anggaran
    Route::resource('/barang', AnggaranController::class)->parameters(['barang' => 'anggaran']);
});

Route::get('/test', function () {
    dd('hello');
})->middleware('can:edit akun');

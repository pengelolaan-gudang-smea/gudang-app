<?php

use App\Http\Controllers\AdminAngaranController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\QrController;
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
        Route::resource('/anggaran',AnggaranController::class);
        Route::resource('/limit-anggaran',LimitController::class)->parameters(['limit-anggaran'=>'limit']);
        });

    // * KKK
    Route::resource('/pengajuan-barang', BarangController::class)->parameters(['pengajuan-barang' => 'barang'])->middleware('can:Mengajukan barang');
    Route::get('/barang-disetujui', [BarangController::class, 'setuju'])->name('barang.setuju');

    // * Admin Anggaran
    Route::resource('/barang-acc', AdminAngaranController::class)->parameters(['barang-acc' => 'acc']);
    Route::post('/filter-jurusan', [AdminAngaranController::class, 'filterJurusan'])->name('filter-jurusan');
    Route::post('/filter-barang', [AdminAngaranController::class, 'filterBarang'])->name('filter-barang');

    // * Admin Gudang
    Route::resource('/barang-gudang',GudangController::class)->parameters(['barang-gudang'=>'gudang']);
    Route::post('/barang-gudang/{slug}/qrcode',[GudangController::class,'Qr'])->name('qr.store');
    Route::post('barang-gudang/qr-generate/{slug}',[GudangController::class,'generateQr']);
});

Route::get('/test', function () {
    return view('dashboard.admingaran.anggaran',[
        'title'=>'hello'
    ]);
});
Route::get('/dashboard/waka/check-anggaran/{id}', [AnggaranController::class, 'checkAnggaran']);

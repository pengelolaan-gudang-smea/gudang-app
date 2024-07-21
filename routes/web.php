<?php

use App\Http\Controllers\AdminAngaranController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\LaporanAsetController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\UserManagementController;
use App\Models\Barang_keluar;
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
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile/{user:username}', [ProfileController::class, 'index'])->name('dashboard.profile');
    Route::put('/profile/{user:username}/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password/{user:username}', [ProfileController::class, 'changePass'])->name('profile.updatePass');

    //  * WAKA
    Route::middleware('can:Edit akun')->group(function () {
        Route::resource('/user', UserManagementController::class);
        Route::post('/hak-akses/{user:username}', [UserManagementController::class, 'akses'])->name('user.akses');
        Route::resource('/anggaran', AnggaranController::class);
        Route::resource('/limit-anggaran', LimitController::class)->parameters(['limit-anggaran' => 'limit']);
        Route::controller(RekapController::class)->group(function () {
            Route::get('/rekap-login', 'rekapLogin')->name('rekap.login');
            Route::get('/rekap-aktivitas', 'rekapActivity')->name('rekap.activity');
            Route::get('/filter', 'filterDate')->name('filter.date');
        });
    });

    // * KKK
    Route::middleware('checkJurusan', 'can:Mengajukan barang')->group(function () {
        Route::resource('/pengajuan-barang', BarangController::class)->parameters(['pengajuan-barang' => 'barang']);
        Route::get('/barang-disetujui', [BarangController::class, 'setuju'])->name('barang.setuju');
    });

    // * Admin Anggaran
    Route::middleware('can:Menyetujui barang')->group(function () {
        Route::resource('/barang-acc', AdminAngaranController::class)->parameters(['barang-acc' => 'acc'])->except('create', 'store', 'destroy');
        Route::post('/filter-jurusan', [AdminAngaranController::class, 'filterJurusan'])->name('filter-jurusan');
        Route::post('/filter-barang', [AdminAngaranController::class, 'filterBarang'])->name('filter-barang');
        Route::put('/barang-accepted/{slug}', [AdminAngaranController::class, 'EditBarangPersetujuan'])->name('persetujuan.editBarang');
        Route::get('/barang-accepted/export', [AdminAngaranController::class, 'export'])->name('barang-acc.export');
    });

    // * Admin Gudang
    Route::middleware('can:Barang gudang')->group(function () {
        Route::resource('/barang-gudang', GudangController::class)->parameters(['barang-gudang' => 'gudang'])->except('edit');
        Route::controller(GudangController::class)->group(function () {
            Route::post('/barang-gudang/{slug}/qrcode', 'Qr')->name('qr.store');
            Route::post('barang-gudang/qr-generate/{slug}', 'generateQr');
            Route::get('/barang-gudang/print/{slug}', 'printQr')->name('print-qr');
            Route::post('/import-barang',  'ImportBarangGudang')->name('import.barang');
        });
    });
    Route::controller(LaporanController::class)->group(function () {
        Route::get('/laporan/barang-gudang', 'index')->name('laporan.gudang');
        Route::post('/filter-laporan', 'filterLaporan')->name('filter-laporan');
        Route::post('/reset-anggaran', 'resetSession')->name('reset-anggaran');
        Route::put('laporan/saldo-keluar/{slug}', 'saldo_keluar')->name('laporan-edit');
        Route::post('laporan/saldo-masuk', 'saldo_masuk')->name('laporan-saldo-masuk');
    });

    Route::controller(LaporanAsetController::class)->group(function(){
Route::get('/laporan-aset/barang-gudang','index')->name('laporan.aset');
Route::post('laporan/filter-jurusan', [LaporanAsetController::class, 'laporanJurusan'])->name('laporan-jurusan');
Route::post('laporan/filter-barang', [LaporanAsetController::class, 'barangJurusan'])->name('barang-jurusan');
Route::get('laporan-aset/barang-gudang/lab-ruang','labRuang')->name('laporan.lab');
Route::post('laporan/filter-ruang-lab', [LaporanAsetController::class, 'laporan_ruang_lab'])->name('laporan-lab_ruang');
Route::post('laporan/filter-barang/ruang-lab', [LaporanAsetController::class, 'barang_ruang_lab'])->name('barang-lab_ruang');

    });
});

Route::get('/dashboard/waka/check-anggaran/{id}/', [AnggaranController::class, 'checkAnggaran']);

Route::get('/dashboard/graphic', [DashboardController::class, 'chartBarang'])->name('chart-barang');
Route::get('/barang-gudang/keluar', function () {
    return view('dashboard.gudang.barang-keluar', ['title' => 'Barang Keluar', 'barang' => Barang_keluar::all()]);
})->name('barang.keluar');
// Route::get

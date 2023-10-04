<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

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
    // * register
    Route::get('/register', 'register')->name('register');
    Route::post('/registered', 'store')->name('register.store');
});

// * forgot & reset password
Route::controller(PasswordController::class)->group(function () {
    Route::get('/forgot-pasword', 'index')->name('forgot.password');
    Route::post('/forgot-password', 'forgot')->name('password.email');

    Route::get('/reset-password/{token}', 'reset')->name('password.reset');
    Route::post('/reset-password', 'update')->name('password.update');
});


// * Dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
});

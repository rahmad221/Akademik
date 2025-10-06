<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\TransaksiPembayaranController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/version', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    // Rute untuk menampilkan dan memproses registrasi
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    // Rute untuk menampilkan dan memproses login
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});


// Rute yang hanya bisa diakses setelah login (Authenticated)
Route::middleware('auth')->group(function () {
    // Contoh rute dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'master'], function () {
        Route::get('users', [UsersController::class, 'index'])->name('master.users');
        Route::put('/users/{id}/role', [UsersController::class, 'updateRole'])->name('master.users.updateRole');
        Route::post('/users/store-ajax', [UsersController::class, 'storeAjax'])->name('master.users.store');
        // route akses
        Route::resource('roles', RoleController::class)->names('master.roles');
        Route::resource('permissions', PermissionController::class)->names('master.permissions');

        // route siswa
        Route::resource('siswa', SiswaController::class)->names('master.siswa');

        // route guru
        Route::resource('guru', GuruController::class)->names('master.guru');
        // route kelas
        Route::resource('kelas', KelasController::class)->names('master.kelas');
        // route jenis pembayaran
        Route::resource('jenis-pembayaran', JenisPembayaranController::class)->names('master.jenis-pembayaran');
    });
    Route::group(['prefix' => 'keuangan'], function () {
        Route::get('/pembayaran', [TransaksiPembayaranController::class, 'index'])->name('keuangan.pembayaran.index');
        Route::get('/pembayaran/create', [TransaksiPembayaranController::class, 'create'])->name('keuangan.pembayaran.create');
        Route::get('/pembayaran/search-siswa', [TransaksiPembayaranController::class, 'searchSiswa'])->name('keuangan.pembayaran.searchSiswa');
        Route::get('/pembayaran/history/{siswa}', [TransaksiPembayaranController::class, 'getHistory'])->name('keuangan.pembayaran.history');
        Route::get('/pembayaran/tunggakan/{siswa}', [TransaksiPembayaranController::class, 'getTunggakan'])->name('keuangan.pembayaran.tunggakan');
        Route::post('/pembayaran/store', [TransaksiPembayaranController::class, 'store'])->name('keuangan.pembayaran.store');
    });

    // Rute untuk logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
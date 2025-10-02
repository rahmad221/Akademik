<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
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

        Route::resource('roles', RoleController::class)->names('master.roles');
        Route::resource('permissions', PermissionController::class)->names('master.permissions');
    });

    // Rute untuk logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
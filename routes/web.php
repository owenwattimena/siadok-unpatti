<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

Route::get('/mail', function () {
    return view('auth.mail-forgot-password');
});
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/post-list', function () {
    return view('web.post-list');
});
Route::get('/post', function () {
    return view('web.post');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.login');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'postEmail'])->name('forgot-password.postEmail');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');

    Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'updatePassword'])->name('reset-password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/dashboard/{nim}', [AlumniController::class, 'update'])->middleware('alumni')->name('my-data.update');
    Route::get('/dashboard/f', [DashboardController::class, 'index'])->name('dashboard-filter')->middleware('not.alumni');

    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [ProfileController::class, 'updateProfile'])->name('dashboard.profile.put');
    Route::put('/dashboard/profile/change-password', [ProfileController::class, 'changePassword'])->name('dashboard.profile.password');

    Route::middleware(['not.alumni'])->group(function(){
        Route::prefix('/city')->group(function () {
            Route::get('/', [LokasiController::class, 'index'])->name('city.index');
            Route::post('/', [LokasiController::class, 'store'])->name('city.store');
            Route::put('{id}', [LokasiController::class, 'update'])->name('city.update');
            Route::delete('{id}', [LokasiController::class, 'delete'])->name('city.delete');
        });
    
        Route::prefix('/alumni')->group(function () {
            Route::get('/', [AlumniController::class, 'index'])->name('alumni.index');
            Route::post('/', [AlumniController::class, 'store'])->name('alumni.store');
            Route::put('{id}', [AlumniController::class, 'update'])->name('alumni.update');
            Route::delete('{id}', [AlumniController::class, 'delete'])->name('alumni.delete');
        });
    
        Route::middleware(['not.admin'])->group(function () {
            Route::prefix('/user')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('user.index');
                Route::post('/', [UserController::class, 'store'])->name('user.store');
                Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
                Route::put('/change-password/{id}', [UserController::class, 'changePassword'])->name('user.password');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.delete');
            });
            Route::prefix('/report')->group(function () {
                Route::get('/', [ReportController::class, 'index'])->name('report.index');
            });
        });
    });
});

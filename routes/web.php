<?php

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

//Route::get('/', function () { return view('welcome'); });

Auth::routes();

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('home');
Route::get('/dashboard/configration', [\App\Http\Controllers\DashboardController::class, 'config'])->name('dashboard.config');
Route::post('/dashboard/setting', [\App\Http\Controllers\DashboardController::class, 'setting'])->name('dashboard.setting');
Route::post('/dashboard/banner', [\App\Http\Controllers\DashboardController::class, 'banner'])->name('dashboard.banner');
Route::post('/dashboard/logo', [\App\Http\Controllers\DashboardController::class, 'logo'])->name('dashboard.logo');
Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::post('user/restore/{user}', [\App\Http\Controllers\UserController::class, 'restore'])->name('users.restore');
    Route::put('user/password/{user}', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('user.password');
    Route::post('user/disable/{user}', [\App\Http\Controllers\UserController::class, 'disable'])->name('disable.user');
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    Route::resource('menus', \App\Http\Controllers\MenuController::class);
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});


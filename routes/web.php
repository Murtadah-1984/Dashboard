<?php

use App\Models\User;
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
Route::get('/dashboard/configuration', [\App\Http\Controllers\DashboardController::class, 'config'])->name('dashboard.config');
Route::post('/dashboard/setting', [\App\Http\Controllers\DashboardController::class, 'setting'])->name('dashboard.setting');
Route::post('/dashboard/banner', [\App\Http\Controllers\DashboardController::class, 'banner'])->name('dashboard.banner');
Route::post('/dashboard/logo', [\App\Http\Controllers\DashboardController::class, 'logo'])->name('dashboard.logo');


Route::middleware('auth')->group(function () {
    Route::get('lang/{locale}', [App\Http\Controllers\LanguageController::class,'setLocale'])->name('setLocale');

    //Global Search Route
    Route::get('/global-search', [\App\Http\Controllers\GlobalSearchController::class,'search'])->name('globalSearch');
    // Model Delete Routes
    Route::delete('/massDestroy', [\App\Http\Controllers\Dashboard\ModelDeleteController::class, 'massDestroy']);
    Route::delete('/forceDelete', [\App\Http\Controllers\Dashboard\ModelDeleteController::class, 'forceDelete']);
    Route::delete('/massForceDelete', [\App\Http\Controllers\Dashboard\ModelDeleteController::class, 'massForceDelete']);
    // Model Restore Routes
    Route::post('/restore', [\App\Http\Controllers\Dashboard\ModelRestoreController::class, 'restore']);
    Route::post('/massRestore', [\App\Http\Controllers\Dashboard\ModelRestoreController::class, 'massRestore']);

    //Users Routes
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('users/password/{user}', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('user.password');
    Route::post('users/disable/{user}', [\App\Http\Controllers\UserController::class, 'disable'])->name('disable.user');
    Route::resource('users', \App\Http\Controllers\UserController::class);

    // Roles Route
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    //Permissions Route
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    //Menu Routes
    Route::resource('menus', \App\Http\Controllers\MenuController::class);
    //Report Routes
    Route::resource('reports', \App\Http\Controllers\ReportController::class);


});


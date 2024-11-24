<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AddDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

// Rute untuk halaman register dan login
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'register_action'])->name('register.action');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');
Route::get('password', [UserController::class, 'password'])->name('password');
Route::post('password', [UserController::class, 'password_action'])->name('password.action');
Route::post('logout', [UserController::class, 'logout'])->name('logout');

// Rute yang memerlukan otentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/report/daily', [ReportController::class, 'daily'])->name('daily');
    Route::get('/report/daily/sort/{status}', [ReportController::class, 'sortByStatus'])->name('daily.sort');
    Route::get('/report/filter/{timeframe}', [ReportController::class, 'filterByTime'])->name('filterByTime');
    Route::get('/report/daily/filterByDate', [ReportController::class, 'filterByDate'])->name('filterByDate');
    Route::get('/report/export/{format}', [ReportController::class, 'export'])->name('report.export');
    Route::get('/report/searchid', function () {
        return view('searchid');
    })->name('searchid');
    Route::post('/report/searchid', [ReportController::class, 'searchById'])->name('searchid.post');
    Route::get('/dashboard/statistics', [DashboardController::class, 'showStatistics'])->name('statistics');
    Route::get('/map', [MapController::class, 'index'])->name('map');
    Route::get('/detail/{id}', [MapController::class, 'showDetail'])->name('detail');

    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/edit-data', [UserController::class, 'editData'])->name('edit-data');
        Route::get('/search-user', [UserController::class, 'searchUser'])->name('search-user');
        Route::get('/search-pelanggan', [UserController::class, 'searchPelanggan'])->name('search-pelanggan');
        Route::post('/update-data-personal', [UserController::class, 'updateDataPersonal'])->name('update-data-personal');
        Route::post('/update-data-penggantian', [UserController::class, 'updateDataPenggantian'])->name('update-data-penggantian');

        // Tambah Data
        Route::get('/add-data', [AddDataController::class, 'index'])->name('add-data');
        Route::post('/add-data', [AddDataController::class, 'store'])->name('add-data.store');
    });
});

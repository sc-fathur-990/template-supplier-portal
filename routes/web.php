<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExampleMenuController;
use App\Http\Controllers\MrpPartSupplierController;
use App\Http\Controllers\MrpSupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Struktur route mengikuti supplier-portal:
|
| 1. Route publik  : login (GET /login, POST /doLogin)
| 2. Route protected: dibungkus middleware 'auth:pub_login'
|    (guard custom, lihat config/auth.php) + 'cek.role'
|    (otorisasi menu berbasis database, lihat app/Http/Middleware/CekRole.php)
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// ---------- Route publik (belum login) ----------
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/doLogin', [AuthController::class, 'doLogin'])->name('doLogin');

// ---------- Route protected (wajib login via guard pub_login) ----------
Route::middleware(['auth:pub_login', 'cek.role'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'doLogout'])->name('logout');

    // Dummy menu sidebar: 1 menu utama dengan 2 submenu.
    // Saat menambah menu baru, daftarkan route-nya di sini lalu insert
    // ke tabel sidemenu/submenu (lihat database/seeders/SidemenuSeeder.php).
    Route::get('/example-menu/list', [ExampleMenuController::class, 'index'])->name('example-menu.index');
    Route::get('/example-menu/create', [ExampleMenuController::class, 'create'])->name('example-menu.create');

    // Master MRP: daftar supplier (mrp_supplier) & part number (mrp_part_supplier)
    Route::get('/mrp-supplier/list', [MrpSupplierController::class, 'index'])->name('mrp-supplier.index');
    Route::get('/mrp-part-supplier/list', [MrpPartSupplierController::class, 'index'])->name('mrp-part-supplier.index');

    Route::get('/not-found', function () {
        return view('errors.not-allowed');
    })->name('not-found');
});

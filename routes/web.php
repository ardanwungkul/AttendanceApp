<?php


use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DivisiController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Absensi;
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





Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::resource('admin/pengguna', UserController::class);
    Route::resource('admin/karyawan', KaryawanController::class);
    Route::resource('admin/divisi', DivisiController::class);
});
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
});


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

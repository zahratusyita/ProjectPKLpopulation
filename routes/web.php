<?php

use App\Http\Controllers\DaerahController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeternakController;
use App\Http\Controllers\TernakController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\MutasiTernakController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('login');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::post('/daerah', [DaerahController::class, 'index'])->middleware('auth')->name('daerah');
Route::get('/daerah', [DaerahController::class, 'index'])->middleware('auth')->name('daerah');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/tahun-data', [HomeController::class, 'tahun_data'])->middleware('auth')->name('tahun-data');
Route::post('/tahun-data-store', [HomeController::class, 'tahun_data_store'])->middleware('auth')->name('tahun-data-store');

Route::get('/user', [UserController::class, 'index'])->middleware('auth')->name('user');
Route::get('/user/form', [UserController::class, 'create'])->middleware('auth')->name('user.form');
Route::post('/user/store', [UserController::class, 'store'])->middleware('auth')->name('user.store');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->middleware('auth')->name('user.edit');
Route::post('/user/update/{id}', [UserController::class, 'update'])->middleware('auth')->name('user.update');
Route::post('/delete-user/{id}', [UserController::class, 'destroy'])->middleware('auth')->name('user.delete');
Route::get('/user/search', [UserController::class, 'search'])->middleware('auth')->name('user.search');
Route::post('/user/import', [UserController::class, 'import'])->middleware('auth')->name('user.import');

Route::get('/peternak', [PeternakController::class, 'index'])->middleware('auth')->name('peternak');
Route::get('/peternak/form', [PeternakController::class, 'create'])->middleware('auth')->name('peternak.form');
Route::get('/peternak/edit/{id}', [PeternakController::class, 'edit'])->middleware('auth')->name('peternak.edit');
Route::post('/peternak/store', [PeternakController::class, 'store'])->middleware('auth')->name('peternak.store');
Route::post('/update-peternak/{id}', [PeternakController::class, 'update'])->middleware('auth')->name('peternak.update');
Route::post('/delete-peternak/{id}', [PeternakController::class, 'destroy'])->middleware('auth')->name('peternak.delete');
Route::get('/peternak/search', [PeternakController::class, 'search'])->middleware('auth')->name('peternak.search');
Route::get('/peternak/export', [PeternakController::class, 'export'])->middleware('auth')->name('peternak.export');
Route::post('/peternak/import', [PeternakController::class, 'import'])->middleware('auth')->name('peternak.import');

Route::get('/ternak', [TernakController::class, 'index'])->middleware('auth')->name('ternak');
Route::get('/ternak/form', [TernakController::class, 'create'])->middleware('auth')->name('ternak.form');
Route::get('/ternak/edit/{id}', [TernakController::class, 'edit'])->middleware('auth')->name('ternak.edit');
Route::post('/ternak/store', [TernakController::class, 'store'])->middleware('auth')->name('ternak.store');
Route::post('/ternak/update/{id}', [TernakController::class, 'update'])->middleware('auth')->name('ternak.update');
Route::post('/ternak/delete/{id}', [TernakController::class, 'destroy'])->middleware('auth')->name('ternak.delete');
Route::get('/ternak/search', [TernakController::class, 'search'])->middleware('auth')->name('ternak.search');
Route::get('/ternak/export', [TernakController::class, 'export'])->middleware('auth')->name('ternak.export');
Route::post('/ternak/import', [TernakController::class, 'import'])->middleware('auth')->name('ternak.import');

Route::get('/verifikasi', [VerifikasiController::class, 'index'])->middleware('auth')->name('verifikasi');
Route::get('/ajukan', [VerifikasiController::class, 'store'])->middleware('auth')->name('ajukan');
Route::post('/verifikasi/update/{id}', [VerifikasiController::class, 'update'])->middleware('auth')->name('verifikasi.update');
Route::post('/verifikasi/cancel/{id}', [VerifikasiController::class, 'cancel'])->middleware('auth')->name('verifikasi.cancel');
Route::get('/verifikasi/search', [VerifikasiController::class, 'search'])->middleware('auth')->name('verifikasi.search');
Route::get('/panduan', [HomeController::class, 'panduan'])->middleware('auth')->name('panduan');

// Mutasi Ternak Routes
Route::get('/mutasi/{jenis}', [MutasiTernakController::class, 'index'])->middleware('auth')->name('mutasi.index');
Route::get('/mutasi/{jenis}/template', [MutasiTernakController::class, 'template'])->middleware('auth')->name('mutasi.template');
Route::get('/mutasi/{jenis}/export', [MutasiTernakController::class, 'export'])->middleware('auth')->name('mutasi.export');
Route::get('/mutasi/{jenis}/form', [MutasiTernakController::class, 'create'])->middleware('auth')->name('mutasi.form');
Route::post('/mutasi/{jenis}/import', [MutasiTernakController::class, 'import'])->middleware('auth')->name('mutasi.import');
Route::post('/mutasi/{jenis}/store', [MutasiTernakController::class, 'store'])->middleware('auth')->name('mutasi.store');
Route::get('/mutasi/{jenis}/edit/{id}', [MutasiTernakController::class, 'edit'])->middleware('auth')->name('mutasi.edit');
Route::post('/mutasi/{jenis}/update/{id}', [MutasiTernakController::class, 'update'])->middleware('auth')->name('mutasi.update');
Route::post('/mutasi/{jenis}/delete/{id}', [MutasiTernakController::class, 'destroy'])->middleware('auth')->name('mutasi.delete');

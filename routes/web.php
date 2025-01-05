<?php

use App\Http\Controllers\AnakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TimbanganController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('role:admin|user');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:admin|user');

// menu anak
Route::get('/anak', [AnakController::class, 'index'])->middleware('role:admin|user');
Route::get('/tambah-anak', [AnakController::class, 'create'])->middleware('role:admin');
Route::post('/tambah-anak', [AnakController::class, 'store'])->middleware('role:admin');
Route::get('/edit-anak/{nik_orangtua}/{anak_ke}', [AnakController::class, 'edit'])->middleware('role:admin');
Route::put('/update-anak/{nik_orangtua}/{anak_ke}', [AnakController::class, 'update'])->middleware('role:admin');
Route::get('/detail-anak/{nik_orangtua}/{anak_ke}', [AnakController::class, 'show'])->middleware('role:admin|user');
Route::delete('/hapus-anak/{nik_orangtua}/{anak_ke}', [AnakController::class, 'destroy'])->middleware('role:admin');

// timbangan
Route::get('/timbangan', [TimbanganController::class, 'index'])->middleware('role:admin|user');
Route::get('/tambah-timbangan', [TimbanganController::class, 'create'])->middleware('role:admin');
Route::post('/tambah-timbangan', [TimbanganController::class, 'store'])->middleware('role:admin');
Route::get('/edit-timbangan/{nik_orangtua}/{anak_ke}/{tanggal_timbangan}', [TimbanganController::class, 'edit'])->middleware('role:admin');
Route::put('/update-timbangan/{nik_orangtua}/{anak_ke}/{tanggal_timbangan}', [TimbanganController::class, 'update'])->middleware('role:admin');
Route::delete('/hapus-timbangan/{nik_orangtua}/{anak_ke}/{tanggal_timbangan}', [TimbanganController::class, 'destroy'])->middleware('role:admin');

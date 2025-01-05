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

Route::get('/dashboard', [DashboardController::class, 'index']);

// menu anak
Route::get('/anak', [AnakController::class, 'index']);
Route::get('/tambah-anak', [AnakController::class, 'create']);
Route::post('/tambah-anak', [AnakController::class, 'store']);
Route::get('/edit-anak/{nik_orangtua}/{anak_ke}', [AnakController::class, 'edit']);
Route::put('/update-anak/{nik_orangtua}/{anak_ke}', [AnakController::class, 'update']);
Route::get('/detail-anak/{nik_orangtua}/{anak_ke}', [AnakController::class, 'show']);
Route::delete('/hapus-anak/{nik_orangtua}/{anak_ke}', [AnakController::class, 'destroy']);

// timbangan
Route::get('/timbangan', [TimbanganController::class, 'index']);
Route::get('/tambah-timbangan', [TimbanganController::class, 'create']);
Route::post('/tambah-timbangan', [TimbanganController::class, 'store']);
Route::delete('/hapus-timbangan/{nik_orangtua}/{anak_ke}', [TimbanganController::class, 'destroy']);

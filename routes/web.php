<?php

use App\Http\Controllers\DaftarController;
use App\Http\Controllers\placeController;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [DaftarController::class, 'index'])->name('daftar.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
// Route::get('/print', [UserController::class, 'print'])->name('user.print');

Route::get('/kantor-1', [placeController::class, 'kantor1'])->name('kantor1.index');
Route::get('/kantor-2', [PlaceController::class, 'kantor2'])->name('kantor2.index');
Route::get('/awak12', [PlaceController::class, 'awak12'])->name('awak12.index');

Route::get('/filter-kantor1', [placeController::class, 'filterKantor1'])->name('filter.kantor1');
Route::get('/filter-kantor2', [placeController::class, 'filterKantor2'])->name('filter.kantor2');
Route::get('/filter-awak12', [placeController::class, 'filterAwak12'])->name('filter.awak12');

Route::get('/print-awak12', [PrintController::class, 'awak12'])->name('print.awak12');
Route::get('/print-kantor1', [PrintController::class, 'kantor1'])->name('print.kantor1');
Route::get('/print-kantor2', [PrintController::class, 'kantor2'])->name('print.kantor2');


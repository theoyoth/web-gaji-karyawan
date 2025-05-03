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

Route::get('/', [DaftarController::class, 'index'])->name('header.index');
Route::get('/user/create/kantor', [UserController::class, 'create'])->name('user.createKantor');
Route::get('/user/create/awak12', [UserController::class, 'createAwak12'])->name('user.createAwak12');
Route::post('/user/create/kantor', [UserController::class, 'store'])->name('user.store');
Route::post('/user/create/awak12', [UserController::class, 'storeAwak12'])->name('user.storeAwak12');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/kantor-1', [placeController::class, 'kantor1'])->name('kantor1.index');
Route::get('/kantor-2', [placeController::class, 'kantor2'])->name('kantor2.index');
Route::get('/awak12', [placeController::class, 'awak12'])->name('awak12.index');

Route::get('/kantor1/filter', [placeController::class, 'filterKantor1'])->name('filter.kantor1');
Route::get('/kantor2/filter', [placeController::class, 'filterKantor2'])->name('filter.kantor2');
Route::get('/awak12/filter', [placeController::class, 'filterAwak12'])->name('filter.awak12');

Route::get('/print/awak12', [PrintController::class, 'awak12'])->name('print.awak12');
Route::get('/print/kantor1', [PrintController::class, 'kantor1'])->name('print.kantor1');
Route::get('/print/kantor2', [PrintController::class, 'kantor2'])->name('print.kantor2');

Route::get('/print/awak12/filter', [PrintController::class, 'filterAwak12'])->name('filterprint.awak12');
Route::get('/print/kantor1/filter', [PrintController::class, 'filterKantor1'])->name('filterprint.kantor1');
Route::get('/print/kantor2/filter', [PrintController::class, 'filterKantor2'])->name('filterprint.kantor2');

Route::get('/awak12/edit/user/{user}', [UserController::class, 'editPageAwak12'])->name('edit.awak12');
Route::put('/awak12/update/user/{userId}', [UserController::class, 'updateAwak12'])->name('update.awak12');

// Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');


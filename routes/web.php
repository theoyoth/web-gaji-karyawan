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
// home
Route::get('/', [DaftarController::class, 'index'])->name('header.index');
// users
// create - form
Route::get('/user/create/kantor', [UserController::class, 'create'])->name('user.createKantor');
Route::get('/user/create/awak12', [UserController::class, 'createAwak12'])->name('user.createAwak12');
// store
Route::post('/user/create/kantor', [UserController::class, 'store'])->name('user.store');
Route::post('/user/create/awak12', [UserController::class, 'storeAwak12'])->name('user.storeAwak12');
// edit
Route::get('/awak12/edit/user/{user}', [UserController::class, 'editPageAwak12'])->name('edit.awak12');
Route::get('/kantor/edit/user/{user}', [UserController::class, 'editPageKantor'])->name('edit.kantor');
// update
Route::put('/awak12/update/user/{userId}', [UserController::class, 'updateAwak12'])->name('update.awak12');
Route::put('/kantor/update/user/{userId}', [UserController::class, 'updateKantor'])->name('update.kantor');
// delete
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

// places
Route::get('/kantor-1', [placeController::class, 'kantor1'])->name('kantor1.index');
Route::get('/kantor-2', [placeController::class, 'kantor2'])->name('kantor2.index');
Route::get('/awak-1-2', [placeController::class, 'filterbyMonthAwak12'])->name('awak12.index');
// filter
Route::get('/kantor-1/filter', [placeController::class, 'filterKantor1'])->name('filter.kantor1');
Route::get('/kantor-2/filter', [placeController::class, 'filterKantor2'])->name('filter.kantor2');
Route::get('/awak-1-2/filter', [placeController::class, 'filterAwak12'])->name('filter.awak12');
Route::get('/awak-1-2/filter', [placeController::class, 'filterbyMonthAwak12'])->name('filterbymonth.awak12');
Route::get('/kantor/filter', [placeController::class, 'filterbyMonthKantor'])->name('filterbymonth.kantor');

// print
Route::get('/print/awak-1-2', [PrintController::class, 'awak12'])->name('print.awak12');
Route::get('/print/kantor-1', [PrintController::class, 'kantor1'])->name('print.kantor1');
Route::get('/print/kantor-2', [PrintController::class, 'kantor2'])->name('print.kantor2');
// filter - print
Route::get('/print/awak-1-2/filter', [PrintController::class, 'filterAwak12'])->name('print.awak12.filtered');
Route::get('/print/kantor-1/filter', [PrintController::class, 'filterKantor1'])->name('print.kantor1.filtered');
Route::get('/print/kantor-2/filter', [PrintController::class, 'filterKantor2'])->name('print.kantor2.filtered');
// search
Route::get('/search/awak-1-2', [UserController::class, 'searchUserAwak12'])->name('search.awak12');
Route::get('/search/kantor', [UserController::class, 'searchUserKantor'])->name('search.kantor');
// Route::get('/search/kantor-2', [UserController::class, 'filterKantor2'])->name('print.kantor2.filtered');

Route::get('/export-awak12', [UserController::class, 'exportAwak12'])->name('export.awak12');

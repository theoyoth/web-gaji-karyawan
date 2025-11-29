<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\placeController;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;


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
// auth route
Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
  Route::get('/', [DaftarController::class, 'index'])->name('home');

  // employees
  // create - form
  Route::get('/employee/create/kantor', [EmployeeController::class, 'create'])->name('employee.createKantor');
  Route::get('/employee/create/awak12', [EmployeeController::class, 'createAwak12'])->name('employee.createAwak12');
  // store
  Route::post('/employee/create/kantor', [EmployeeController::class, 'store'])->name('employee.store');
  Route::post('/employee/create/awak12', [EmployeeController::class, 'storeAwak12'])->name('employee.storeAwak12');
  // edit
  Route::get('/kantor/edit/employee/{employeeId}/{employeeSalaryId}', [EmployeeController::class, 'editPageKantor'])->name('edit.kantor');
  Route::get('/awak12/edit/employee/{employeeId}/{employeeSalaryId}', [EmployeeController::class, 'editPageAwak12'])->name('edit.awak12');
  // updateR
  Route::put('/awak12/update/employee/{employeeId}', [EmployeeController::class, 'updateAwak12'])->name('update.awak12');
  Route::put('/kantor/update/employee/{employeeId}', [EmployeeController::class, 'updateKantor'])->name('update.kantor');
  // delete
  Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

  // places
  Route::get('/kantor-1', [placeController::class, 'kantor1'])->name('kantor1.index');
  Route::get('/kantor-2', [placeController::class, 'kantor2'])->name('kantor2.index');
  // filter
  Route::get('/awak-1-2', [placeController::class, 'filterbyMonthAwak12'])->name('awak12.index');
  // Route::get('/kantor-1/filter', [placeController::class, 'filterKantor1'])->name('filter.kantor1');
  // Route::get('/kantor-2/filter', [placeController::class, 'filterKantor2'])->name('filter.kantor2');

  // Route::get('/awak-1-2/filter', [placeController::class, 'filterbyMonthAwak12'])->name('filterbymonth.awak12');
  Route::get('/kantor', [placeController::class, 'filterbyMonthKantor'])->name('filterbymonth.kantor');
  Route::get('/operator-helper', [placeController::class, 'filterbyMonthOperatorHelper'])->name('filterbymonth.operatorhelper');

  // print
  Route::get('/print/awak-1-2', [PrintController::class, 'awak12'])->name('print.awak12');
  Route::get('/print/kantor-1', [PrintController::class, 'kantor1'])->name('print.kantor1');
  Route::get('/print/kantor-2', [PrintController::class, 'kantor2'])->name('print.kantor2');
  // filter - print
  Route::get('/print/awak-1-2/filter', [PrintController::class, 'filterAwak12'])->name('print.awak12.filtered');
  Route::get('/print/kantor-1/filter', [PrintController::class, 'filterKantor1'])->name('print.kantor1.filtered');
  Route::get('/print/kantor-2/filter', [PrintController::class, 'filterKantor2'])->name('print.kantor2.filtered');
  // search
  Route::get('/search/awak-1-2', [EmployeeController::class, 'searchEmployeeAwak12'])->name('search.awak12');
  Route::get('/search/kantor', [EmployeeController::class, 'searchEmployeeKantor'])->name('search.kantor');
  // Route::get('/search/kantor-2', [EmployeeController::class, 'filterKantor2'])->name('print.kantor2.filtered');

  Route::get('/export-awak12', [EmployeeController::class, 'exportAwak12'])->name('export.awak12');

});
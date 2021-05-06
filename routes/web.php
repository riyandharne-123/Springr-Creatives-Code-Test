<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\EmployeeController::class, 'index']);

Route::group(['prefix' => 'employee'], function() {
    Route::post('/store', [App\Http\Controllers\EmployeeController::class, 'store']);
    Route::get('/get/{id}', [App\Http\Controllers\EmployeeController::class, 'show']);
    Route::post('/delete', [App\Http\Controllers\EmployeeController::class, 'destroy']);
});

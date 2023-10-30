<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

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

Route::get('/', [FormController::class, 'dashboard']);
Route::get('/create', [FormController::class, 'create']);
Route::get('/edit/{id}', [FormController::class, 'edit']);
Route::post('/update', [FormController::class, 'update']);
Route::get('/list', [FormController::class, 'list']);

Route::post('/store', [FormController::class, 'store']);
Route::post('/form-submit', [FormController::class, 'submit']);
Route::get('/form-template/{id}', [FormController::class, 'getFormTemplate']);
Route::get('/json-list', [FormController::class, 'jsonList']);

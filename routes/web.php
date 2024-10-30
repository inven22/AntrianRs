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

// Route::get('/', function () {
//     return view('antrian.baris');
// });
 
Route::get('/', [App\Http\Controllers\screenantrian::class, 'index'])->name('index');
Route::get('/helo', [App\Http\Controllers\screenantrian::class, 'helo']);
Route::get('layout', [App\Http\Controllers\layouts::class, 'layouts']);

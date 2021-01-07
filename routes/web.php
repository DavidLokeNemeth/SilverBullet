<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SyncController;

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

Route::get('/', function () {
    return view('welcome', ['title'=>'Welcome']);
});

Route::get('/admin/list', [AdminController::class, 'getProperties'])->name('property.list');

Route::get('/sync', [SyncController::class, 'runSynchronisation'])->name('sync');

Route::group(['middleware'=>'web'], function(){
    Route::resource('/admin', AdminController::class);
});

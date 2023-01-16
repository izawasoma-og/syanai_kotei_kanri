<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return Redirect::to('/home');
});

Auth::routes();


Route::group(["middleware" => "auth"], function(){
    
    Route::get('/home', [App\Http\Controllers\ProjectController::class, 'projectList'])->name('home');
    
    //顧客関連
    Route::get('/clientList', [App\Http\Controllers\ClientController::class, 'clientList'])->name('clientList');
    Route::get('/clientAdd', [App\Http\Controllers\ClientController::class, 'clientAdd'])->name('clientAdd');
    Route::post('/clientInsert', [App\Http\Controllers\ClientController::class, 'clientInsert'])->name('clientInsert');
    Route::get('/clientEdit/{id}', [App\Http\Controllers\ClientController::class, 'clientEdit'])->name('clientEdit');
    Route::post('/clientUpdate', [App\Http\Controllers\ClientController::class, 'clientUpdate'])->name('clientUpdate');
    
    //案件関連
    Route::get('/projectAdd', [App\Http\Controllers\ProjectController::class, 'projectAdd'])->name('projectAdd');
    Route::post('/projectInsert', [App\Http\Controllers\ProjectController::class, 'projectInsert'])->name('projectInsert');
    Route::get('/projectList', [App\Http\Controllers\ProjectController::class, 'projectList'])->name('projectList');
    Route::get('/projectEdit/{id}', [App\Http\Controllers\ProjectController::class, 'projectEdit'])->name('projectEdit');
    Route::post('/projectUpdate', [App\Http\Controllers\ProjectController::class, 'projectUpdate'])->name('projectUpdate');

    //日報関連
    Route::get('/reportAdd', [App\Http\Controllers\ReportController::class, 'reportAdd'])->name('reportAdd');
    Route::post('/reportInsert', [App\Http\Controllers\ReportController::class, 'reportInsert'])->name('reportInsert');
    Route::get('/reportList', [App\Http\Controllers\ReportController::class, 'reportList'])->name('reportList');
    Route::get('/reportEdit/{id}', [App\Http\Controllers\ReportController::class, 'reportEdit'])->name('reportEdit');

    //ユーザー関連
    Route::get('/passUpdate', [App\Http\Controllers\UserController::class, 'goPassUpdate'])->name('goPassUpdate');
    Route::post('/passUpdate', [App\Http\Controllers\UserController::class, 'passUpdate'])->name('passUpdate');
    Route::get('/passUpdateComp', [App\Http\Controllers\UserController::class, 'passUpdateComp'])->name('passUpdateComp');
});
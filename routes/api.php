<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/client', [App\Http\Controllers\ClientController::class, 'getClientList']);
Route::get('/project', [App\Http\Controllers\ProjectController::class, 'getProjectList']);
Route::get('/operation', [App\Http\Controllers\OperationController::class, 'getOperationList']);
Route::put('/report', [App\Http\Controllers\ReportController::class, 'putReport']);
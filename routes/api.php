<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('person')->group(function () {
    Route::post('/create', [PersonController::class, 'create']);
    Route::get('list', [PersonController::class, 'list']);
    Route::get('read/{id}', [PersonController::class, 'read']);
    Route::put('update/{id}', [PersonController::class, 'update']);
    Route::delete('delete/{id}', [PersonController::class, 'delete']);
});

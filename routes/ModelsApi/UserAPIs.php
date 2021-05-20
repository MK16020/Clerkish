<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [UserController::class, 'index']);
        Route::post('insert', [UserController::class, 'insert']);
        Route::put('update', [UserController::class, 'update']);
        Route::get('show/{userID}', [UserController::class, 'show']);
        Route::delete('delete/{userID}', [UserController::class, 'delete']);
        });
    });
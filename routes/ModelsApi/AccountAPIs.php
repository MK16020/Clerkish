<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'preferences'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [AccountController::class, 'index']);
        Route::post('insert', [AccountController::class, 'insert']);
        Route::put('update', [AccountController::class, 'update']);
        Route::get('show/{preferenceID}', [AccountController::class, 'show']);
        Route::delete('delete/{preferenceID}', [AccountController::class, 'delete']);
        });
    });

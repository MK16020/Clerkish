<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'accounts'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [AccountController::class, 'index']);
        Route::post('insert', [AccountController::class, 'insert']);
        Route::put('update', [AccountController::class, 'update']);
        Route::get('show/{accountID}', [AccountController::class, 'show']);
        Route::delete('delete/{accountID}', [AccountController::class, 'delete']);
        });
    });

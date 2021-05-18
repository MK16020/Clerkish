<?php

use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'preferences'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [VoucherController::class, 'index']);
        Route::post('insert', [VoucherController::class, 'insert']);
        Route::put('update', [VoucherController::class, 'update']);
        Route::get('show/{preferenceID}', [VoucherController::class, 'show']);
        Route::delete('delete/{preferenceID}', [VoucherController::class, 'delete']);
        });
    });
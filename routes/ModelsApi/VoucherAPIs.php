<?php

use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'vouchers'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [VoucherController::class, 'index']);
        Route::post('insert', [VoucherController::class, 'insert']);
        Route::put('update', [VoucherController::class, 'update']);
        Route::get('show/{voucherID}', [VoucherController::class, 'show']);
        Route::delete('delete/{voucherID}', [VoucherController::class, 'delete']);
        });
    });
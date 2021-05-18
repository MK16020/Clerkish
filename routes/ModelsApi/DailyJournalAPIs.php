<?php

use App\Http\Controllers\DailyJournalController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'preferences'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [DailyJournalController::class, 'index']);
        Route::post('insert', [DailyJournalController::class, 'insert']);
        Route::put('update', [DailyJournalController::class, 'update']);
        Route::get('show/{preferenceID}', [DailyJournalController::class, 'show']);
        Route::delete('delete/{preferenceID}', [DailyJournalController::class, 'delete']);
        });
    });
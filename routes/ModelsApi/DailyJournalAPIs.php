<?php

use App\Http\Controllers\DailyJournalController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'journals'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [DailyJournalController::class, 'index']);
        Route::post('insert', [DailyJournalController::class, 'insert']);
        Route::put('update', [DailyJournalController::class, 'update']);
        Route::get('show/{journalID}', [DailyJournalController::class, 'show']);
        Route::delete('delete/{journalID}', [DailyJournalController::class, 'delete']);
        });
    });
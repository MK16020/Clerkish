<?php

use App\Http\Controllers\AccountJournalController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'preferences'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [AccountJournalController::class, 'index']);
        Route::post('insert', [AccountJournalController::class, 'insert']);
        Route::put('update', [AccountJournalController::class, 'update']);
        Route::get('show/{preferenceID}', [AccountJournalController::class, 'show']);
        Route::delete('delete/{preferenceID}', [AccountJournalController::class, 'delete']);
        });
    });
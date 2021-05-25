<?php

use App\Http\Controllers\AccountJournalController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'accountJournals'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('index', [AccountJournalController::class, 'index']);
        Route::post('insert', [AccountJournalController::class, 'insert']);
        /*Route::put('update', [AccountJournalController::class, 'update']);
        Route::get('show/{accountJournalID}', [AccountJournalController::class, 'show']);*/
        Route::delete('delete/{accountJournalID}', [AccountJournalController::class, 'delete']);
        });
    });
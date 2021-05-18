<?php

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

require_once 'ModelAPI/AccountAPIs.php';
require_once 'ModelAPI/AccountJournalAPIs.php';
require_once 'ModelAPI/DailyJournalAPIs.php';
require_once 'ModelAPI/UserAPIs.php';
require_once 'ModelAPI/VoucherAPIs.php';

Route::get('state', function () {
    return 'active';
})->withoutMiddleware(['ActiveUser']);

Route::get('test', function () {
    $year = Carbon::now()->format('H:m:s');

    return $local = env('FALLBACK_LOCALE');

})->withoutMiddleware(['ActiveUser']);

Route::group(['prefix' => 'communications'], function () {
    Route::delete('delete/{communicaionID}', [Controller::class, 'removeConnection']);
});

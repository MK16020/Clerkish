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

require_once 'ModelsApi/AccountAPIs.php';
require_once 'ModelsApi/AccountJournalAPIs.php';
require_once 'ModelsApi/DailyJournalAPIs.php';
require_once 'ModelsApi/UserAPIs.php';
require_once 'ModelsApi/VoucherAPIs.php';

Route::get('state', function () {
    return 'active';
})->withoutMiddleware(['ActiveUser']);

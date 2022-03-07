<?php
use Illuminate\Support\Facades\Route;
use Kanexy\Cms\Middleware\ColorModeMiddleware;
use Kanexy\Cms\Middleware\ValidateRegistrationCompletedMiddleware;
use Kanexy\InternationalTransfer\Http\Controllers\InternationalTransferController;
use Kanexy\MarketPlace\Http\Controllers\RegistrationServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web','auth',ColorModeMiddleware::class]], function () {
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('international-transfers',[InternationalTransferController::class,'index']);
    });
});


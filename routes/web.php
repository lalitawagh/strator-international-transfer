<?php
use Illuminate\Support\Facades\Route;
use Kanexy\Cms\Middleware\ColorModeMiddleware;
use Kanexy\InternationalTransfer\Http\Controllers\CollectionAccountController;
use Kanexy\InternationalTransfer\Http\Controllers\TransferTypeFeeController;


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
    Route::group(['prefix' => 'dashboard/international-transfer', 'as' => 'dashboard.international-transfer.'], function () {
        Route::resource("transfer-type-fee",TransferTypeFeeController::class)->only(['index', 'create', 'store', 'show', 'edit', 'destroy', 'update']);
        Route::resource("collection-account",CollectionAccountController::class)->only(['index', 'store']);
    });
});


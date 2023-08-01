<?php


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

// Route::middleware('auth:api')->get('/ledgerfoundation', function (Request $request) {
//     return $request->user();
// });

use Illuminate\Support\Facades\Route;
use Kanexy\InternationalTransfer\Http\Controllers\CurrencyCloudPartnerController;

Route::get('cc-partner-users-kyc/{id}',[CurrencyCloudPartnerController::class,'ccPartnerUsersKycDetails'])->name('cc-partner-users-kyc');

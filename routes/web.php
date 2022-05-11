<?php
use Illuminate\Support\Facades\Route;
use Kanexy\Cms\Middleware\ColorModeMiddleware;
use Kanexy\InternationalTransfer\Http\Controllers\FeeController;
use Kanexy\InternationalTransfer\Http\Controllers\MasterAccountController;
use Kanexy\InternationalTransfer\Http\Controllers\MoneyTransferController;
use Kanexy\InternationalTransfer\Http\Controllers\TransferReasonController;
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
        Route::resource("transfer-reason",TransferReasonController::class);
        Route::resource("master-account",MasterAccountController::class)->only(['index', 'store']);
        Route::resource("transfer-type-fee",TransferTypeFeeController::class);
        Route::resource("fee",FeeController::class);
        Route::resource("money-transfer",MoneyTransferController::class)->only(['index', 'store', 'create']);
        Route::get("money-transfer/beneficiary",[MoneyTransferController::class, 'showBeneficiary'])->name('money-transfer.beneficiary');
        Route::get("money-transfer/payment",[MoneyTransferController::class, 'showPaymentMethod'])->name('money-transfer.payment');
        Route::post("money-transfer/transaction-detail",[MoneyTransferController::class, 'transactionDetail'])->name('money-transfer.transactionDetail');
        Route::get("money-transfer/preview",[MoneyTransferController::class, 'preview'])->name('money-transfer.preview');
        Route::get("money-transfer/cancel-transfer/{id}",[MoneyTransferController::class, 'cancel'])->name('money-transfer.cancelTransfer');
        Route::get("money-transfer/final-detail",[MoneyTransferController::class, 'finalizeTransfer'])->name('money-transfer.final');
        Route::get("money-transfer/final",[MoneyTransferController::class, 'showFinalizeTransfer'])->name('money-transfer.showFinal');
        Route::get("money-transfer/verify",[MoneyTransferController::class, 'verify'])->name('money-transfer.verify');
        Route::get("money-transfer/stripe",[MoneyTransferController::class, 'stripe'])->name('money-transfer.stripe');
        Route::post("money-transfer/stripe-initialize",[MoneyTransferController::class, 'stripeInitialize'])->name('money-transfer.stripeInitialize');
        Route::post("money-transfer/stripe-payment",[MoneyTransferController::class, 'storeStripePaymentDetails'])->name('money-transfer.stripePayment');

    });
});


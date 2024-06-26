<?php

use Illuminate\Support\Facades\Route;
use Kanexy\Cms\Middleware\ColorModeMiddleware;
use Kanexy\Cms\Middleware\VerificationStepMiddleware;
use Kanexy\InternationalTransfer\Http\Controllers\AgentController;
use Kanexy\InternationalTransfer\Http\Controllers\BalanceController;
use Kanexy\InternationalTransfer\Http\Controllers\CcAccountSettingController;
use Kanexy\InternationalTransfer\Http\Controllers\ConversionController;
use Kanexy\InternationalTransfer\Http\Controllers\CurrencyCloudPartnerController;
use Kanexy\InternationalTransfer\Http\Controllers\CountryController;
use Kanexy\InternationalTransfer\Http\Controllers\BalancesCountryController;
use Kanexy\InternationalTransfer\Http\Controllers\DashboardController;
use Kanexy\InternationalTransfer\Http\Controllers\FeeController;
use Kanexy\InternationalTransfer\Http\Controllers\MasterAccountController;
use Kanexy\InternationalTransfer\Http\Controllers\MembershipComponentController;
use Kanexy\InternationalTransfer\Http\Controllers\MoneyTransferBeneficiaryController;
use Kanexy\InternationalTransfer\Http\Controllers\MoneyTransferController;
use Kanexy\InternationalTransfer\Http\Controllers\RiskManagementController;
use Kanexy\InternationalTransfer\Http\Controllers\RiskMgmtQuestionController;
use Kanexy\InternationalTransfer\Http\Controllers\TransferReasonController;
use Kanexy\InternationalTransfer\Http\Controllers\TransferTypeFeeController;
use Kanexy\InternationalTransfer\Http\Controllers\ExchangeRateController;

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

Route::group(['middleware' => ['web', 'auth', ColorModeMiddleware::class]], function () {
        Route::group(['prefix' => 'dashboard/international-transfer', 'as' => 'dashboard.international-transfer.'], function () {
                Route::name('money-transfer-dashboard')->get('/', [DashboardController::class, 'index']);
                Route::resource("risk-management-questions", RiskMgmtQuestionController::class);
                Route::resource("transfer-reason", TransferReasonController::class);
                Route::resource("master-account", MasterAccountController::class)->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
                Route::resource("transfer-type-fee", TransferTypeFeeController::class);
                Route::resource("exchange-rate", ExchangeRateController::class);
                Route::resource("fee", FeeController::class);
                Route::resource("country",CountryController::class);
                Route::resource("balances-country",BalancesCountryController::class);
                Route::resource("money-transfer", MoneyTransferController::class)->only(['index', 'store', 'create']);
                Route::get("money-transfer-review", [MoneyTransferController::class, 'review'])->name('money-transfer-review');
                Route::get("money-transfer/beneficiary", [MoneyTransferController::class, 'showBeneficiary'])->name('money-transfer.beneficiary');
                Route::post("money-transfer/beneficiary-store", [MoneyTransferController::class, 'beneficiaryStore'])->name('money-transfer.beneficiaryStore');
                Route::get("money-transfer/payment", [MoneyTransferController::class, 'showPaymentMethod'])->name('money-transfer.payment');
                Route::post("money-transfer/transaction-detail", [MoneyTransferController::class, 'transactionDetail'])->name('money-transfer.transactionDetail');
                Route::get("money-transfer/preview", [MoneyTransferController::class, 'preview'])->name('money-transfer.preview');
                Route::get("money-transfer/cancel-transfer/{id}", [MoneyTransferController::class, 'cancel'])->name('money-transfer.cancelTransfer');
                Route::get("money-transfer/final-detail", [MoneyTransferController::class, 'finalizeTransfer'])->name('money-transfer.final');
                Route::get("money-transfer/final", [MoneyTransferController::class, 'showFinalizeTransfer'])->name('money-transfer.showFinal');
                Route::get("money-transfer/verify", [MoneyTransferController::class, 'verify'])->name('money-transfer.verify');
                Route::get("money-transfer/stripe", [MoneyTransferController::class, 'stripe'])->name('money-transfer.stripe');
                Route::get("money-transfer/total-processing", [MoneyTransferController::class, 'totalProcessingRequest'])->name('money-transfer.total-processing');
                Route::post("money-transfer/stripe-initialize", [MoneyTransferController::class, 'stripeInitialize'])->name('money-transfer.stripeInitialize');
                Route::post("money-transfer/stripe-payment", [MoneyTransferController::class, 'storeStripePaymentDetails'])->name('money-transfer.stripePayment');
                Route::get("money-transfer/transfer-completed/{id}", [MoneyTransferController::class, 'transferCompleted'])->name('money-transfer.transferCompleted');
                Route::get("money-transfer/transfer-accepted/{id}", [MoneyTransferController::class, 'transferAccepted'])->name('money-transfer.transferAccepted');
                Route::get("money-transfer/transfer-pending/{id}", [MoneyTransferController::class, 'transferPending'])->name('money-transfer.transferPending');
                Route::post("money-transfer/logs", [MoneyTransferController::class, 'logDetails'])->name('money-transfer.logDetails');
                Route::get('money-transfer/pdf/{transaction_id}', [MoneyTransferController::class, 'moneyTransferPDF'])->name("money-transfer.moneytransfersPdf");
                Route::get("admin-approval/{id}", [MoneyTransferController::class, 'adminApproval'])->name("approval");
                Route::get("money-transfer/transfer-declined/{id}", [MoneyTransferController::class, 'transferDeclined'])->name('money-transfer.transferDeclined');
                Route::get("money-transfer/total-processing/get-status", [MoneyTransferController::class, 'storeTotalProcessingDetails'])->name('total-processing.status');
                Route::get("risk-management", [RiskManagementController::class, 'createRiskManagement'])->name('riskManagement');
                Route::post("risk-management-store", [RiskManagementController::class, 'storeRiskCountry'])->name('risk-store-country');
                Route::resource('beneficiaries', MoneyTransferBeneficiaryController::class);
                Route::get('workspaces/{workspace}/exchangerate-information', [MembershipComponentController::class, 'showExchangeRateInfo'])->name('membership-exchangerate-information');
                Route::post('exchangerate-information/{workspace}', [MembershipComponentController::class, 'updateExchangeRateInformation'])->name('membership.store.exchangerate-information');
                Route::get('agent-requests', [AgentController::class, 'agentRequest'])->name('agent-request');
                Route::resource('agent', AgentController::class);
                Route::get('agent-detail/{id}', [AgentController::class, 'agentDetail'])->name('agent-detail');
                Route::get('agent-users/{id}', [AgentController::class, 'agentUsers'])->name('agent-users');
                Route::get('agent-transactions/{id}', [AgentController::class, 'agentTransactions'])->name('agent-transactions');
                Route::resource('cc-partners', CurrencyCloudPartnerController::class);
                Route::get('cc-partners-approve/{id}', [CurrencyCloudPartnerController::class,'approve'])->name('cc-partners-approve');
                Route::get('approve-partners', [CurrencyCloudPartnerController::class,'approvePartners'])->name('approve-partners');
                Route::post('cc-partners-update/{id}', [CurrencyCloudPartnerController::class,'update'])->name('cc-partners-update');
                Route::get('archived-transactions', [MoneyTransferController::class, 'archivedTransactions'])->name('archivedTransactions');
                Route::resource('cc-account-settings', CcAccountSettingController::class)->only(['index', 'create', 'store', 'show']);
                Route::post('cc-payout', [MoneyTransferController::class,'ccPayout'])->name('cc-payout');
                Route::get('cc-partner-accounts/{id}', [CurrencyCloudPartnerController::class,'ccPartnerAccounts'])->name('cc-partner-accounts');
                Route::get('cc-partner-transactions/{id}', [CurrencyCloudPartnerController::class,'ccPartnerTransactions'])->name('cc-partner-transactions');
                Route::resource("conversion", ConversionController::class)->only(['index', 'store', 'create']);
                Route::resource("balance", BalanceController::class)->only(['index', 'store', 'create']);
                Route::get('add-balance', [BalanceController::class,'addBalance'])->name('add-balance');
                Route::get('currency-details/{id}', [BalanceController::class,'currencyDetails'])->name('currency-details');
                Route::get('conversion/preview', [ConversionController::class,'conversionPreview'])->name('conversion-preview');
                Route::get('conversion/final', [ConversionController::class,'showFinalizeConversion'])->name('conversion-final');
                Route::get('conversion-list', [ConversionController::class,'conversionList'])->name('conversion-list');
                Route::get('balance-currency/{id}',[BalanceController::class,'balanceCurrency'])->name('balance-currency');
                Route::get('partner-users-kyc/{partnerId}/{id}',[CurrencyCloudPartnerController::class,'partnerUsersKyc'])->name('partner-users-kyc');
        });

        Route::group(['middleware' => ['auth', '\Kanexy\Cms\Middleware\ColorModeMiddleware', VerificationStepMiddleware::class], 'prefix' => 'dashboard/international-transfer', 'as' => 'dashboard.international-transfer.'], function () {
                Route::name('money-transfer-dashboard')->get('/', [DashboardController::class, 'index']);
        });
        Route::group(['prefix' => 'dashboard/workspaces/{workspace?}', 'as' => 'dashboard.workspaces.'], function () {
            Route::get('exchangerate-information', [MembershipComponentController::class, 'showExchangeRateInfo'])->name('membership-exchangerate-information');

        });
});

Route::group(['middleware' => ['web']], function () {
Route::post('webhooks/fxmaster', 'Kanexy\InternationalTransfer\Webhooks\FxmasterCcWebhook')->name('webhooks.fxmaster');
});

<?php

use App\Livewire\Account\ChartOfAccountComponent;
use App\Livewire\Account\BankPaymentVoucherComponent;
use App\Livewire\Account\CashPaymentVoucherComponent;
use App\Livewire\Account\BankReceiptVoucherComponent;
use App\Livewire\Account\CashReceiptVoucherComponent;
use App\Livewire\Account\JvVoucherComponent;
use App\Livewire\Account\DailyCashBookComponent;
use App\Livewire\Account\LedgerComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('admin/login');
})->name('home');


Route::group(['middleware' => 'auth'], function () {
    /////Account//////
    // Route::get('admin/chartof/account', ChartOfAccountComponent::class)->name('account.chartofaccount');
    // Route::get('admin/bank/payment/voucher', BankPaymentVoucherComponent::class)->name('account.bank.payment.voucher');
    // Route::get('admin/cash/payment/voucher', CashPaymentVoucherComponent::class)->name('account.cash.payment.voucher');
    // Route::get('admin/bank/receipt/voucher', BankReceiptVoucherComponent::class)->name('account.bank.receipt.voucher');
    // Route::get('admin/cash/receipt/voucher', CashReceiptVoucherComponent::class)->name('account.cash.receipt.voucher');
    // Route::get('admin/jv/voucher', JvVoucherComponent::class)->name('account.jv.voucher');
    // Route::get('admin/daily/cashbook', DailyCashBookComponent::class)->name('cashbook');
    // Route::get('admin/account/ledger', LedgerComponent::class)->name('account.ledger');
});

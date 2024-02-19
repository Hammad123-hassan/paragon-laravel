<?php

namespace App\Livewire\Account;

use App\Models\Account\ChartOfAccount;

use App\Models\VoucherDetail;
use Livewire\Component;

class LedgerComponent extends Component
{
    public $date_from;
    public $date_to;
    public $parttaker_id;
    public $accounts = [];
    public $openingBalance;
    public $ledger  = [];
    public function mount()
    {
        // $this->getAccounts();
        $this->getChartofAccount();
        $this->date_from = date('Y-m-d');
        $this->date_to = date('Y-m-d');
    }
    public function getChartofAccount()
    {
        $this->accounts = ChartOfAccount::where('level', 3)->get();
    }
    public function render()
    {
        return view('livewire.account.ledger-component');
    }
    public function getData()
    {
        $this->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'parttaker_id' => 'required|exists:chart_of_accounts,id',
        ]);
        $account = ChartOfAccount::find($this->parttaker_id);
        $this->openingBalance = VoucherDetail::select('voucher_details.*', 'vouchers.voucher_date', 'vouchers.voucher_no')
            ->join('vouchers', 'vouchers.id', 'voucher_details.voucher_id')
            ->where('account_id', $this->parttaker_id)
            ->whereDate('voucher_date', '<', $this->date_from)
            ->get();
        $this->openingBalance = collect($this->openingBalance);
        $this->openingBalance = ($this->openingBalance->sum('debit_amount') - $this->openingBalance->sum('credit_amount')) + ($account->debit - $account->credit);

        $this->ledger = VoucherDetail::select('voucher_details.*', 'vouchers.voucher_date', 'vouchers.voucher_no')
            ->join('vouchers', 'vouchers.id', 'voucher_details.voucher_id')
            ->where('account_id', $this->parttaker_id)
            ->whereBetween('voucher_date', [date($this->date_from), date($this->date_to)])
            ->get();
    }
}

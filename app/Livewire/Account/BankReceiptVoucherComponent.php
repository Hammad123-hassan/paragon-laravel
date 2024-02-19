<?php

namespace App\Livewire\Account;

use App\Http\Controllers\CommonController;
use App\Models\Account\ChartOfAccount;
use App\Models\AccountVoucher;
use App\Models\BankPaymentVoucher;
use App\Models\BankPaymentVoucherDetail;

use App\Models\Voucher;
use App\Models\VoucherDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BankReceiptVoucherComponent extends Component
{
    public $viewStatus = true;
    public $data;
    public $show;
    public $accounts = [];
    public $credit_amounts = [];
    public $accountheads = [];
    public $totalAmount;

    protected $rules = [
        'data.voucher_date' => 'required',
        'data.account_from' => 'required',
        'data.credit_amount' => 'required',
        'data.account_to' => 'required',
        'data.memo' => 'required',
        'data.debit_amount' => 'required',
    ];
    public function mount()
    {
        $this->show = CommonController::checkPermission();
        $this->getChartofAccount();
        $this->data['active'] = true;
        $this->data['credit_amount'] = 0;
        $this->data['debit_amount'] = 0;
        $this->data['voucher_date'] = date('Y-m-d');
    }
    public function getChartofAccount()
    {
        $this->show = CommonController::checkPermission();
        $this->accounts = ChartOfAccount::where('active', 1)->where('level', 3)
        ->whereIn('show', $this->show)->where('account_type', 'bank')->get();
    }
    public function render()
    {
        return view('livewire.account.bank-receipt-voucher-component');
    }
    public function addNewBank()
    {
        $this->viewStatus = true;
    }
    public function admissionList()
    {
        $this->viewStatus = false;
    }
    public function getAccountHeads()
    {
            $this->show = CommonController::checkPermission();
            $this->accountheads =  ChartOfAccount::where('active', 1)->where('id', '!=', $this->data['account_from'])->where('level', 3)
            ->whereIn('show', $this->show)->get();
            $this->dispatch('post-created', accountheads: $this->accountheads);
        
    }
    public function addDebit()
    {
        $this->validate();
        
        if ($this->data['credit_amount'] > 0) 
        {
        $sum = 0;
        foreach ($this->credit_amounts as $item) {
            $sum += $item['credit_amount'] ?? 0;
        }
    
        // Set the debit amount to the total credit amount
        $this->data['debit_amount'] = $sum + $this->data['credit_amount'];
    
        // Add the credit entry to the list of credit_amounts
        array_push($this->credit_amounts, [
            'account_to' => $this->data['account_to'],
            'memo' => $this->data['memo'],
            'credit_amount' => $this->data['credit_amount'],
        ]);
    
        // Clear the input fields
        $this->data['account_to'] = '';
        $this->data['memo'] = '';
        $this->data['credit_amount'] = '';
        $this->dispatch('resetData');
        } 
        else 
        {
            session()->flash('error', 'Error! Credit amount must be greater than 0.');
        }
    }    
    public function deleteRecord($key)
    {
        // Ensure that the key exists
        if (isset($this->credit_amounts[$key])) {
            $debitAmount = $this->credit_amounts[$key]['credit_amount'];
    
            // Update the credit amount by subtracting the deleted debit amount
            $this->data['debit_amount'] -= $debitAmount;
    
            // Remove the record from the debit_amounts array
            unset($this->credit_amounts[$key]);
    
            // Re-index the array to remove any gaps in the keys
            $this->credit_amounts = array_values($this->credit_amounts);
        }
    }
    
    public function store()
    {
        $this->validate([
            'data.voucher_date' => 'required',
            'data.account_from' => 'required',
        ]);
    
        $creditAmountsSum = array_sum(array_column($this->credit_amounts, 'credit_amount'));
        if ($this->data['debit_amount'] != $creditAmountsSum) {
            session()->flash('error', 'Error! Debit and credit amounts do not match');
            return;
        }
    
        try {
            // Transaction
            $exception = DB::transaction(function () {
                $user = Auth::user();
                $voucher = Voucher::forceCreate([
                    'type' => 2,
                    'voucher_date' => $this->data['voucher_date'],
                    'active' => $this->data['active'],
                    'user_id' => $user->id,
                ]);
                $voucher->voucher_no = date('Y') . date('m') . date('d') . $voucher->id;
                $voucher->update();
    
                $voucherDetail = new VoucherDetail();
                $voucherDetail->voucher_id = $voucher->id;
                $voucherDetail->account_id = $this->data['account_from'];
                $voucherDetail->debit_amount = $this->data['debit_amount'];
                $voucherDetail->active = $this->data['active'];
                $voucherDetail->save();
    
                foreach ($this->credit_amounts as $item) {
                    VoucherDetail::forceCreate([
                        'account_id' => $item['account_to'],
                        'memo' => $item['memo'],
                        'credit_amount' => $item['credit_amount'],
                        'voucher_id' => $voucher->id,
                        'active' => $this->data['active'],
                    ]);
                }
    
                $this->reset();
                $this->data['voucher_date'] = date('Y-m-d');
                session()->flash('success', 'Success! Voucher created successfully');
                $this->dispatch('resetForm');
            });
    
            if (is_null($exception)) {
                return true;
            } else {
                throw new Exception;
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('error', 'Error! Incorrect data');
        }
    }
    
    public function updateCreditAmount()
    {
        if (isset($this->data['debit_amount'])) {
            $this->data['credit_amount'] = $this->data['debit_amount'];
        } else {
            session()->flash('error', 'Error! Incorrect data');
        }
    }
    
}

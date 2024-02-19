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

class CashPaymentVoucherComponent extends Component
{
    public $viewStatus = true;
    public $data;
    public $show;
    public $accounts = [];
    public $debit_amounts = [];
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
        ->whereIn('show',$this->show)->where('account_type', 'cash')->get();
    }
    public function render()
    {
        return view('livewire.account.cash-payment-voucher-component');
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
           ->whereIn('show',$this->show)->get();
            $this->dispatch('post-created', accountheads: $this->accountheads);
        
    }
    public function addDebit()
    {
        $this->validate();
        if ($this->data['debit_amount'] > 0) 
        {
        $sum = 0;
        foreach ($this->debit_amounts as $item) {
            $sum += $item['debit_amount'] ?? 0;
        }
        $this->data['credit_amount'] = $sum + $this->data['debit_amount'];
        array_push($this->debit_amounts,  [
            'account_to' => $this->data['account_to'],
            'memo' => $this->data['memo'],
            'debit_amount' => $this->data['debit_amount'],
            'cheque_no' => $this->data['cheque_no'] ?? null,
            'cheque_id' => $this->data['cheque_id'] ?? null,
        ]);
    
        // Clear the input fields
        $this->data['account_to'] = '';
        $this->data['memo'] = '';
        $this->data['debit_amount'] = '';
        $this->dispatch('resetData');
        } 
        else 
            {
                session()->flash('error', 'Error! Debit amount must be greater than 0.');
            }
    }    
    
    
    public function deleteRecord($key)
    {
        // Ensure that the key exists
        if (isset($this->debit_amounts[$key])) {
            $debitAmount = $this->debit_amounts[$key]['debit_amount'];
    
            // Update the credit amount by subtracting the deleted debit amount
            $this->data['credit_amount'] -= $debitAmount;
    
            // Remove the record from the debit_amounts array
            unset($this->debit_amounts[$key]);
    
            // Re-index the array to remove any gaps in the keys
            $this->debit_amounts = array_values($this->debit_amounts);
        }
    }
    public function store()
    {
        $this->validate([
            'data.voucher_date' => 'required',
            'data.account_from' => 'required',
        ]);
        $debitAmountsSum = array_sum(array_column($this->debit_amounts, 'debit_amount'));
        if ($this->data['credit_amount'] != $debitAmountsSum) {
            session()->flash('error', 'Error! Debit and credit amounts do not match');
            return;
        }
        try {
            // Transaction
            $exception = DB::transaction(function () {
                $user = Auth::user();
                $voucher = Voucher::forceCreate([
                    'type' => 3,
                    'voucher_date' => $this->data['voucher_date'],
                    'active' => $this->data['active'],
                    'user_id' => $user->id,
                ]);
                $voucher->voucher_no = date('Y') . date('m') . date('d') . $voucher->id;
                $voucher->update();
                $voucherDetail = new VoucherDetail();
                $voucherDetail->voucher_id = $voucher->id;
                $voucherDetail->account_id = $this->data['account_from'];
                $voucherDetail->credit_amount = $this->data['credit_amount'];
                $voucherDetail->active = $this->data['active'];
                $voucherDetail->save();
                foreach ($this->debit_amounts as $item) {
                    VoucherDetail::forceCreate([
                        'account_id' => $item['account_to'],
                        'memo' => $item['memo'],
                        'debit_amount' => $item['debit_amount'],
                        'voucher_id' => $voucher->id,
                        'active' => $this->data['active'],
                    ]);
                }
                $this->reset();
                $this->data['voucher_date'] = date('Y-m-d');
                // $this->dispatchBrowserEvent('alert', [
                //     'type' => 'success',
                //     'message' => "Voucher Create successfully"
                // ]);
                session()->flash('success', 'Success! Voucher Create successfully');
                $this->dispatch('resetForm');
                return;
            });
            if (is_null($exception)) {
                return true;
            } else {
                throw new Exception;
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            // $this->dispatchBrowserEvent('alert', [
            //     'type' => 'error',
            //     'message' => "Incorrect data"
            // ]);
            session()->flash('error', 'Error! Incorrect data');
            return;
        }
    }

    public function updateDebitAmount()
    {
        if (isset($this->data['credit_amount'])) {
            $this->data['debit_amount'] = $this->data['credit_amount'];
        } else {
            session()->flash('error', 'Error! Incorrect data');
        }
    }
    
}

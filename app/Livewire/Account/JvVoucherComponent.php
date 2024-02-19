<?php

namespace App\Livewire\Account;

use App\Models\Account\ChartOfAccount;
use App\Models\AccountVoucher;
use App\Models\BankPaymentVoucher;
use App\Models\BankPaymentVoucherDetail;

use App\Models\Voucher;
use App\Models\VoucherDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class JvVoucherComponent extends Component
{
    public $viewStatus = true;
    public $data;
    public $accounts = [];
    public $amounts = [];
    public $accountheads = [];
    public $totalAmount;


    protected $rules = [
        'data.voucher_date' => 'required',
        'data.account_id' => 'required',
        'data.memo' => 'required',
    ];
    public function mount()
    {
        $this->data['active'] = true;
        $this->data['credit_amount'] = 0;
        $this->data['debit_amount'] = 0;
        $this->data['voucher_date'] = date('Y-m-d');
        $this->getChartofAccount();
    }
    public function getChartofAccount()
    {
        $user = auth()->user();
        if ($user->hasRole('Super Admin')) {
            $this->accountheads =  ChartOfAccount::where('active', 1)->where('level', 3)->get();
        } else {
            $this->accountheads =  ChartOfAccount::where('active', 1)->where('level', 3)->where('show', 'yes')->get();
        }
    }
    public function render()
    {
        return view('livewire.account.jv-voucher-component');
    }
    public function resetCreditAmount()
    {

        if (!(int)$this->data['debit_amount']) {
            $this->data['debit_amount'] = '';
        }
        $this->data['credit_amount'] = 0;
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
        $user = auth()->user();
        if ($user->hasRole('Super Admin')) {
            $this->accountheads =  ChartOfAccount::where('active', 1)
                ->where('id', '!=', $this->data['account_from'])->where('level', 3)->get();
        } else {
            $this->accountheads =  ChartOfAccount::where('active', 1)
                ->where('id', '!=', $this->data['account_from'])->where('level', 3)->where('show', 'yes')->get();
        }
    }
    public function addDebit()
    {
        $this->validate();
        $sum = 0;
        foreach ($this->amounts as $item) {
            $sum += $item['credit_amount'] ?? 0;
        }
        $this->totalAmount = $sum + $this->data['credit_amount'];
        // if($this->totalAmount > $this->data['debit_amount'])
        // {
        //     $this->dispatchBrowserEvent('alert', [
        //         'type' => 'error',
        //         'message' => "Incorrect amount"
        //     ]);
        //     return;
        // }
        // dd($this->data);
        array_push($this->amounts,  ['account_id' => $this->data['account_id'], 'memo' => $this->data['memo'], 'credit_amount' => $this->data['credit_amount'], 'debit_amount' => $this->data['debit_amount']]);
        // $this->data['account_id'] = '';
        $this->data['memo'] = '';
        $this->data['credit_amount'] = 0;
        $this->data['debit_amount'] = 0;
        $this->dispatch('resetData');
    }
    public function deleteRecord($key)
    {
        unset($this->amounts[$key]);
    }
    public function store()
    {
        $this->validate([
            'data.voucher_date' => 'required',
            'data.master_memo' => 'required',
        ]);
        if (sizeof($this->amounts) == 0) {
            // $this->dispatchBrowserEvent('alert', [
            //     'type' => 'error',
            //     'message' => "Record not found"
            // ]);
            session()->flash('error', 'Error! Record not found');
            return;
        }
        $credit_amount = array_sum(array_map(function ($element) {
            return $element['credit_amount'];
        }, $this->amounts));
        $debit_amount = array_sum(array_map(function ($element) {
            return $element['debit_amount'];
        }, $this->amounts));

        if ($credit_amount != $debit_amount) {
            // $this->dispatchBrowserEvent('alert', [
            //     'type' => 'error',
            //     'message' => "Incorrect amount"
            // ]);
            session()->flash('error', 'Error! Incorrect amount');
            return;
        }
        try {
            // Transaction
            $exception = DB::transaction(function () {
                $user = Auth::user();
                $voucher = Voucher::forceCreate([
                    'type' => 5,
                    'voucher_date' => $this->data['voucher_date'],
                    'memo' => $this->data['master_memo'],
                    'active' => $this->data['active'],
                    'user_id' => $user->id,
                ]);
                $voucher->voucher_no = date('Y') . date('m') . date('d') . $voucher->id;
                $voucher->update();

                foreach ($this->amounts as $item) {
                    VoucherDetail::forceCreate([
                        'account_id' => $item['account_id'],
                        'memo' => $item['memo'],
                        'credit_amount' => $item['credit_amount'] ?? 0,
                        'debit_amount' => $item['debit_amount'] ?? 0,
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
                return;
            });
            if (is_null($exception)) {
                return true;
            } else {
                throw new \Exception;
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
}

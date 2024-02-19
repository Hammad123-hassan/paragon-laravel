<?php

namespace App\Livewire\Account;

use App\Models\Account\ChartOfAccount;
use App\Models\Checkbook;
use App\Models\Voucher;
use App\Models\VoucherDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CheckbookComponent extends Component implements HasForms, HasTable
{


    use InteractsWithTable;
    use InteractsWithForms;
    public $viewStatus = false;
    public $data;
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
        $this->getChartofAccount();
        $this->data['active'] = true;
    }
    public function getChartofAccount()
    {
        $this->accounts = ChartOfAccount::where('active', 1)->where('level', 3)->where('account_type', 'bank')->get();
    }
    public function render()
    {
        return view('livewire.account.checkbook-component');
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
        // dd($this->data['account_from']);
        $this->accountheads =  ChartOfAccount::where('active', 1)->where('id', '!=', $this->data['account_from'])->where('level', 3)->get();
        $this->dispatch('post-created', accountheads: $this->accountheads);
        // dd($this->accountheads);
        // $this->render();
    }
    public function addDebit()
    {
        $this->validate();
        $sum = 0;
        foreach ($this->debit_amounts as $item) {
            $sum += $item['debit_amount'] ?? 0;
        }
        $this->totalAmount = $sum + $this->data['debit_amount'];
        if ($this->totalAmount > (float)$this->data['credit_amount']) {
            // $this->dispatchBrowserEvent('alert', [
            //     'type' => 'error',
            //     'message' => "Incorrect amount"
            // ]);
            session()->flash('error', 'Error! Incorrect amount');
            return;
        }
        array_push($this->debit_amounts,  ['account_to' => $this->data['account_to'], 'memo' => $this->data['memo'], 'debit_amount' => $this->data['debit_amount']]);
        $this->data['account_to'] = '';
        $this->data['memo'] = '';
        $this->data['debit_amount'] = '';
    }
    public function deleteRecord($key)
    {
        unset($this->debit_amounts[$key]);
    }
    public function store()
    {



        $this->validate([
            'data.bank_name' => 'required',
            'data.format' => 'required',
            'data.pages' => 'required',
        ]);



        try {
            // Transaction
            $exception = DB::transaction(function () {
                Checkbook::forceCreate([
                    'bank_name' => $this->data['bank_name'],
                    'format' => $this->data['format'],
                    'pages' => $this->data['pages']
                ]);
                $this->data['bank_name'] = null;
                $this->data['format'] = null;
                $this->data['pages'] = null;
                session()->flash('success', 'Success! Checkbook Create successfully');
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
        }
    }

    public function updateDebitAmount()
    {
        $this->data['debit_amount'] = $this->data['credit_amount'];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Checkbook::query())
            ->columns([
                TextColumn::make('bank_name')->searchable(),
                TextColumn::make('format')->searchable(),
                TextColumn::make('pages')->searchable(),
                \Filament\Tables\Columns\ToggleColumn::make('active')
            ])

            ->actions([
                // ...
            ]);
    }
}

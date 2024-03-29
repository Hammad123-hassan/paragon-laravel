<?php

namespace App\Livewire\Account;

use App\Models\Account\ChartOfAccount;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class ChartOfAccountComponent extends Component
{
    public $accounts = [];
    public $viewStatus;
    public $mainAccounts = [];
    public $record;
    public $levelFilter;
    public $branches;
    public function mount()
    {
        $this->getChartofAccount();
    }
    public function getChartofAccount()
    {
        $this->accounts = ChartOfAccount::whereIn('level', [1, 2])->get();

        $this->mainAccounts = ChartOfAccount::where('level', 1)->get();
    }
    public function render()
    {
        return view('livewire.account.chart-of-account-component');
    }
    public function ListAdd()
    {
        $this->resetForm();
        $this->viewStatus = true;
    }
    //
    public function listView()
    {
        $this->resetForm();
        $this->viewStatus = false;
    }
    public function resetForm()
    {
        $this->levelFilter = null;

        $this->record['parent_chart_of_account_id'] = null;
        $this->record['title'] = null;
        $this->record['id'] = null;
    }
    public function editAccount($data)
    {

        $this->viewStatus = true;
        $this->record = $data;
    }
    public function createAccount()
    {
        // dd($this->record);
        $this->validate([
            'record.parent_chart_of_account_id' => 'nullable|exists:chart_of_accounts,id',
            'record.title' => 'required',
            'record.show' => 'nullable',
            'record.category' => 'nullable',

        ]);

        //Check if any previous account id is provided for update
        if (isset($this->record['id'])) {

            //Check if the id provided is valid
            $record = ChartOfAccount::find($this->record['id']);
            if (!$record) {
                //If provided id is not valid return and error response
                // return response([
                //     'message' => 'error',
                //     'data' => []
                // ], 422);
                session()->flash('error', 'Error! The selected parent account can not have any sub account.');
                return;
                // $this->dispatchBrowserEvent('alert', [
                //     'type' => 'error',
                //     'message' => "Error! The selected parent account can not have any sub account"
                // ]);
            }

            //If provided id is correct update the account with the provided title
            $record->title = $this->record['title'];

            $record->account_type = $this->record['account_type'];
            $record->show = $this->record['show'];
            $record->category = $this->record['category'];

            $record->update();

            session()->flash('success', 'Account update successfully.');
            // $this->dispatchBrowserEvent('alert', [
            //     'type' => 'success',
            //     'message' => "Account update successfully"
            // ]);
            $this->viewStatus = false;
            $this->getChartofAccount();
            // $this->accounts = ChartOfAccount::whereIn('parent_chart_of_account_id', [0, 1])->get();
            // $this->mainAccounts = ChartOfAccount::where('level', 1)->get();
            return;
        }

        //Account level will be one if no parent account is provided
        $accountLevel = 1;
        //Main account will be the account's id if no parent account is provided the main_chart_of_account_id is updated after account is created
        $mainAccount = null;

        $code = 0;
        $accountNumber = 0;

        $parentAccount = ChartOfAccount::find($this->record['parent_chart_of_account_id'] ?? '');

        if ($parentAccount) {
            //Main account = parent account's main account if parent exists
            $mainAccount = $parentAccount->main_chart_of_account_id;
            //Increase account level if account is created under a parent account
            $accountLevel += $parentAccount->level;

            //If parent account is already the highest as defined in chartofaccount model then it can't have any further child
            if ($parentAccount->level == ChartOfAccount::$levels) {
                // return response([
                //     'message' => 'Error! The selected parent account can not have any sub account',
                //     'data' => null
                // ], 422);
                // $this->dispatchBrowserEvent('alert', [
                //     'type' => 'error',
                //     'message' => "Error! The selected parent account can not have any sub account"
                // ]);
                session()->flash('error', 'Error! The selected parent account can not have any sub account');
            }

            //Account code of the child account will be generated by getting the max code where parent id is same as new account's parent if no account exists then will start with 0
            $maxCode = ChartOfAccount::where('level', $accountLevel)->where('parent_chart_of_account_id', $parentAccount->id)->max('code') ?? 0;
            $code = str_pad($maxCode + 1, $accountLevel == ChartOfAccount::$levels ? 6 : 4, '0', STR_PAD_LEFT);
            //Account number will be generated by concatenating parent account's account number as suffix with the new account's code
            $accountNumber = $parentAccount->account_number . '-' . $code;
        } else {
            //If account is a main account which do not have any parent the code will be generate with increment of 1 in max code of a main account
            $maxCode = ChartOfAccount::where('level', 1)->max('code');
            //Account number will be the same as code
            $accountNumber = $code = str_pad($maxCode + 1, ChartOfAccount::$levels <= 2 ? 4 : 2, '0', STR_PAD_LEFT);
        }

        //If account is a main account which do not have any parent the code will be generate with increment of 1 in max code of a main account
        $account = ChartOfAccount::forceCreate([
            'parent_chart_of_account_id' => $this->record['parent_chart_of_account_id'] ?? '',
            'main_chart_of_account_id' => $mainAccount,
            'title' => $this->record['title'],


            'code' => $code,
            'account_number' => $accountNumber,
            'account_type' => $this->record['account_type'] ?? 'normal',
            'level' => $accountLevel,
            'active' => true,
            'show' => $this->record['show'],
            'category' => $this->record['category'],
        ]);


        if ($mainAccount == null) {
            $account->main_chart_of_account_id = $account->id;
            $account->update();
        }

        // $this->dispatchBrowserEvent('alert', [
        //     'type' => 'success',
        //     'message' => "Account create successfully"
        // ]);
        session()->flash('success', 'Account create successfully');
        $this->viewStatus = false;
        $this->record['parent_chart_of_account_id'] = '';
        $this->record['title'] = '';
        $this->getChartofAccount();
        // $this->accounts = ChartOfAccount::whereIn('parent_chart_of_account_id', [0, 1])->get();
        // $this->mainAccounts = ChartOfAccount::where('level', 1)->get();
        // $this->reset();

    }
}

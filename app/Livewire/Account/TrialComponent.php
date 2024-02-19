<?php

namespace App\Livewire\Account;

use App\Models\Account\ChartOfAccount;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class TrialComponent extends Component
{
    public $accounts = [];
    public $viewStatus;
    public $mainAccounts = [];
    public $record;
    public $levelFilter;
    public $levelThree;
    public $mainHead;
    public $date_from;
    public $date_to;
    public $level = 1;
    public function mount()
    {
        $this->date_from = date('Y-m-d');
        $this->date_to = date('Y-m-d');
        $this->getChartofAccount();
    }
    public function getChartofAccount()
    {
        $this->accounts = ChartOfAccount::whereIn('parent_chart_of_account_id', [0, 1])->get();

        $this->mainAccounts = ChartOfAccount::where('level', $this->level)->get();
        $this->levelThree = ChartOfAccount::where('level', 3)->get();
    }
    public function render()
    {
        return view('livewire.account.trial-component');
    }
    public function ListAdd()
    {
        $this->resetForm();
        $this->viewStatus = true;
    }
    public function updatedLevel()
    {
        // $this->level
        $this->getChartofAccount();
    }
}

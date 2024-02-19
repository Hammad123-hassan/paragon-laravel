<?php

namespace App\Livewire\Salary;

use App\Models\SalaryBonusDeduction;
use App\Models\SalarySlip;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GenerateSalaryComponent extends Component
{
    public $month;
    public $userId;
    public $year;
    public $users;
    public $deduction;
    public $bonus;
    public $baseSalary;
    public function mount()
    {
        $this->getUser();
        $this->year = date('Y');
    }
    public function updatedMonth()
    {
        if ($this->month && $this->year) {
            $this->getUser();
        }
    }
    public function updatedYear()
    {
        if ($this->month && $this->year) {
            $this->getUser();
        }
    }
    public function getUser()
    {
        $this->users = User::where('active', 1)->where('salary', '>', 0)->get();
        foreach ($this->users as $user) {
            $getSalary = SalaryBonusDeduction::where('user_id', $user->id)
                ->whereHas('salary', function ($query) {
                    $query->where('month', $this->month)
                        ->where('year', $this->year);
                })
                ->first();
            $this->deduction[$user->id] = $getSalary->deduction ?? null;
            $this->bonus[$user->id] = $getSalary->bonus ?? null;
        }
    }

    public function render()
    {
        return view('livewire.salary.generate-salary-component');
    }

    public function openModal($userId)
    {
        if (!$this->month || !$this->year) {
            session()->flash('error', 'Please select year or month');
            return;
        }

        $this->userId = $userId;
        $this->dispatch('openModal');
    }


    public function paidMark($userId)
    {

        if (!$this->month || !$this->month) {
            session()->flash('error', 'Please select year or month');
            return;
        }
        $getSalary = SalaryBonusDeduction::where('user_id', $userId)
            ->whereHas('salary', function ($query) {
                $query->where('month', $this->month)
                    ->where('year', $this->year);
            })
            ->first();
        if (!$getSalary) {
            session()->flash('error', 'Please generate salary first');
            return;
        }

        $getSalary->paid_mark = auth()->user()->id;
        $getSalary->update();
        session()->flash('success', 'Success! Paid Successfully!');
        $this->dispatch('closeModal');
    }

    public function store()
    {
        $this->validate([
            'month' => 'required',
            'year' => 'required',
        ]);

        // try {
        // DB::beginTransaction();

        $salarySlip = SalarySlip::where('month', $this->month)->where('year', $this->year)->first();
        if ($salarySlip) {
            $salarySlip->month = $this->month;
            $salarySlip->year = $this->year;
            SalaryBonusDeduction::where('salary_bonus_deduction_id', $salarySlip->id)->where('paid_mark', 0)->delete();
        } else {
            $salarySlip = SalarySlip::forceCreate([
                'month' => $this->month,
                'year' => $this->year,
                'user_id' => auth()->user()->id,
            ]);
        }
        foreach ($this->users as $user) {
            SalaryBonusDeduction::forceCreate([
                'salary_bonus_deduction_id' => $salarySlip->id,
                'user_id' => $user->id,
                'deduction' => $this->deduction[$user->id],
                'bonus' => $this->bonus[$user->id],
            ]);
        }

        session()->flash('success', 'Success! Salary Genearted successfully');
        //     DB::commit(); // Commit the transaction if everything is successful
        // } catch (\Exception $e) {
        //     // Rollback the transaction in case of an exception
        //     DB::rollback();
        //     // You can log the exception or handle it as needed
        //     report($e);
        //     // Optionally, rethrow the exception if you want to propagate it
        //     // throw $e;
        // }
    }
}

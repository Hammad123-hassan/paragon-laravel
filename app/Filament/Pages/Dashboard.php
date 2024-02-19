<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BranchList;
use App\Filament\Widgets\CaseRegister;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Intake;
use App\Models\StudentCase;
use App\Models\University;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected static ?string $navigationGroup = 'Home';
    protected static ?int $navigationSort = 1;
    public $branches;
    public $countries;
    public $users;
    public $universities;
    public $totalCase;
    public $completedCase;
    public $aborted;
    public $ongoing;
    public $monthWise;
    public $intake_id;
    public $intakes;

    public function mount()
    {
        $this->branches = Branch::where('active', 1)->count();
        $this->users = User::where('active', 1)->count();
        $this->countries = Country::where('active', 1)->count();
        $this->universities = University::where('active', 1)->count();

        $user = Auth::user();
        $this->intakes = Intake::get();
        $this->updateDashboard();
    }

    public function updatedIntakeId()
    {
        $this->updateDashboard();
    }

    public function updateDashboard()
    {
        $user = Auth::user();
        $casesQuery = StudentCase::query();

        if ($user->roles->count() > 0) {
            foreach ($user->roles as $role) {
                switch ($role->id) {
                    case 3:
                        $casesQuery->orWhere('created_by', $user->id);
                        break;

                    case 2:
                        $branchesId = $user->branches->pluck('id')->toArray();
                        $casesQuery->orWhereIn('branch_id', $branchesId);
                        break;



                    default:

                        break;
                }
            }
        } else {
            // Only user-specific data when no roles are assigned
            $casesQuery->where('created_by', $user->id);
        }

        // Add the condition for intake_id after the loop
        if ($this->intake_id) {
            $intake = Intake::findOrFail($this->intake_id);
            $casesQuery->where('intake_id', $intake->id);
        }

        // Count total cases
        $this->totalCase = $casesQuery->count();

        // Count completed cases
        $completedCasesQuery = clone $casesQuery;
        $this->completedCase = $completedCasesQuery->where('status', 'VISA DECISION')
            ->where('case_status', '!=', 'Aborted')
            ->count();

        // Count ongoing cases
        $ongoingCasesQuery = clone $casesQuery;
        $this->ongoing = $ongoingCasesQuery->where('status', '!=', 'VISA DECISION')
            ->where('case_status', '!=', 'Aborted')
            ->count();

        // Count aborted cases
        $abortedCasesQuery = clone $casesQuery;
        $this->aborted = $abortedCasesQuery->where('case_status', 'Aborted')
            ->count();
    }







    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    protected static string $view = 'filament.pages.dashboard';

    protected ?string $heading = '';

    protected static ?string $navigationLabel = 'Dashboard';
}

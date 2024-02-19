<?php

namespace App\Livewire\Account;

use App\Models\Branch;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherDetail;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VoucherReportComponent extends Component
{
    public $startDate;
    public $endDate;
    public $selectedType;
    public $selectedAccount;
    public $vouchers;
    public $getvoucher = [];
    public $selectedBranch;
    public $voucherDetails = [];
    public $voucherIdToDelete;


    public function mount()
    {
        $this->startDate = date('Y-m-d');
        $this->endDate = date('Y-m-d');
        $this->selectedType = 0;
    }

    public function getInformation($voucherId)
    {
        $this->getvoucher = VoucherDetail::where('voucher_id', $voucherId)->get();
        $this->dispatch('open-modal', id: 'edit-user');
    }

    public function closeModal()
    {
        $this->getvoucher = [];
        $this->dispatch('close-modal', ['id' => 'edit-user']);
    }

    public function render()
    {
        $typeOptions = [
            '0' => 'All',
            '1' => 'Bank Payment',
            '2' => 'Bank Receipt',
            '3' => 'Cash Payment',
            '4' => 'Cash Receipt',
            '5' => 'JV Voucher',
        ];
    
        $user = auth()->user();
        $branchQuery = Branch::query();

        if ($user->hasRole('Branch Manager')) {
            $branchQuery->whereHas('users', function ($userQuery) use ($user) {
                $userQuery->where('users.id', $user->id);
            });
        }

        $branches = $branchQuery->get();
    
        // Fetch vouchers with associated users
        $vouchers = Voucher::with('users')->get();
    
        return view('livewire.account.voucher-report-component', compact('branches', 'typeOptions', 'vouchers'));
    }
    

    public function generateReport()
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $query = Voucher::query();

        if ($this->selectedType != '0') {
            $query->where('type', $this->selectedType);
        }

        if ($this->selectedBranch) {
            $usersInBranch = User::whereHas('branches', function ($branchQuery) {
                $branchQuery->where('branch_id', $this->selectedBranch);
            })->pluck('id');

            $query->whereIn('user_id', $usersInBranch);
        }

        $user = auth()->user();
        if ($user->hasRole('Counsellor')) {
            $query->where('user_id', $user->id);
        }

        $query->whereBetween('voucher_date', [$startDate, $endDate]);

        $this->vouchers = $query->with('voucherDetail')->orderBy('created_at', 'desc')->get();

        return view('livewire.account.voucher-report-component', ['vouchers' => $this->vouchers]);
    }

    public function softDeleteConfirmation($voucherId)
    {
        $this->voucherIdToDelete = $voucherId;
        $this->dispatch('confirm-delete');
    }

    public function softDelete()
    {
        $voucher = Voucher::find($this->voucherIdToDelete);

        if ($voucher) {
            $today = now()->startOfDay(); // Get the start of today
            if ($voucher->created_at->greaterThanOrEqualTo($today)) {
                $voucher->delete();
                $this->vouchers = $this->vouchers->filter(function ($item) {
                    return $item->id !== $this->voucherIdToDelete;
                });
            }
        }
        $this->dispatch('close-delete-modal');
    }
}

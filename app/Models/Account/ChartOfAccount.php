<?php

namespace App\Models\Account;

use App\Models\Campus;
use App\Models\Branch;
use App\Models\VoucherDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    public $appends = ['mainhead'];

    public static $levels = 3;

    public function subAccounts()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_chart_of_account_id', 'id');
    }

    public static function mainAccounts()
    {
        return self::where('level', 1)->with('subAccounts.subAccounts.subAccounts');
    }

    public function mainAccountGet()
    {
        return ChartOfAccount::where('id', $this->parent_chart_of_account_id)->pluck('title')->first();
    }
    public function subAccountGet()
    {
        return ChartOfAccount::where('id', $this->main_chart_of_account_id)->pluck('title')->first();
    }

    public function trial()
    {
        $debit = VoucherDetail::where('account_id', $this->id)->sum('debit_amount');
        $credit = VoucherDetail::where('account_id', $this->id)->sum('credit_amount');
        return $debit - $credit;
    }

    public function mainHeadTrial(array $data)
    {
        // $openingBalance = ($openingBalance->sum('debit_amount') - $openingBalance->sum('credit_amount'));
        // + ($account->debit - $account->credit);
        // $debit = VoucherDetail::whereIn('account_id', $accounts)->sum('debit_amount');
        // $credit = VoucherDetail::whereIn('account_id', $accounts)->sum('credit_amount');

        $accounts = ChartOfAccount::where('main_chart_of_account_id', $data['mainId'])->pluck('id');


        $openingBalance = VoucherDetail::select('voucher_details.*', 'vouchers.voucher_date', 'vouchers.voucher_no')
            ->join('vouchers', 'vouchers.id', 'voucher_details.voucher_id')
            ->whereIn('account_id', $accounts)
            ->whereDate('voucher_date', '<', $data['date_from'])
            ->get();
        $openingBalance = collect($openingBalance);
        ///////

        $closingBalance = VoucherDetail::select('voucher_details.*', 'vouchers.voucher_date', 'vouchers.voucher_no')
            ->join('vouchers', 'vouchers.id', 'voucher_details.voucher_id')
            ->whereIn('account_id', $accounts)
            ->whereDate('voucher_date', '>', $data['date_to'])
            ->get();
        $closingBalance = collect($closingBalance);


        $currentOpeningBalance = VoucherDetail::select('voucher_details.*', 'vouchers.voucher_date', 'vouchers.voucher_no')
            ->join('vouchers', 'vouchers.id', 'voucher_details.voucher_id')
            ->whereIn('account_id', $accounts)
            // ->whereDate('voucher_date',  $data['date_from'])
            ->whereBetween('voucher_date', [$data['date_from'], $data['date_to']])
            ->get();
        $currentOpeningBalance = collect($currentOpeningBalance);
        //////

        $data['openingDebit'] = $openingBalance->sum('debit_amount');
        $data['openingCredit'] = $openingBalance->sum('credit_amount');
        ////////////
        $data['currentgDebit'] = $currentOpeningBalance->sum('debit_amount');
        $data['currentCredit'] = $currentOpeningBalance->sum('credit_amount');

        $data['closingDebit'] = $closingBalance->sum('debit_amount');
        $data['closingCredit'] = $closingBalance->sum('credit_amount');
        return $data;
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function getMainheadAttribute()
    {
        return $this->mainAccountGet();
    }
}

<?php

namespace App\Models;

use App\Models\Account\ChartOfAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class VoucherDetail extends Model
{
    use HasFactory;
    
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function chart()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }
}

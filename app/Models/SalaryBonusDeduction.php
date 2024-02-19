<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryBonusDeduction extends Model
{
    use HasFactory;
    protected $fillable = [
        'paid_mark'
    ];
    public function salary()
    {
        return $this->belongsTo(SalarySlip::class, 'salary_bonus_deduction_id');
    }
}

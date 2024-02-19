<?php

namespace App\Models;

use App\Models\Account\ChartOfAccount;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'name',
        'description',
        'active',
    ];



    public function lead()
    {
        return $this->hasMany(StudentCase::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function account()
    {
        return $this->hasMany(ChartOfAccount::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'active',
        'created_by',
        'updated_by',
    ];

    public function studentCases()
    {
        return $this->hasMany(StudentCase::class, 'intake_id');
    }
}

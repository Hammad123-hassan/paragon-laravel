<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_case_id',
        'schedule_date',
        'mock_interview_date',
        'official_interview_date',
        'result_date',
        'status'
    ];


    
}

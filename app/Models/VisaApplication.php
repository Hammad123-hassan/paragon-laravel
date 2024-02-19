<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_case_id',
        'applied',
        'date_of_application',
        'date_of_apppointment',

    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class VisaDecision extends Model  implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = [
        'student_case_id',
        'status',

        'date_of_decision',

    ];
}

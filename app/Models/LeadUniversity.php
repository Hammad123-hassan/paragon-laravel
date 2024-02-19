<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadUniversity extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'country_id',
        'university_id',
        'degree_id',
        'applied_uni',
        'col',
        'uol',
        'university_student_id',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
}

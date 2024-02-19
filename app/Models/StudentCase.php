<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class StudentCase extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = [
        'degree_id',
        'intake_id',
        'name',
        'city',
        'cnic',
        'branch_id',
        'offer_letter_condition',
        'dob',
        'email',
        'phone',
        'active',
        'status',
        'description',
        'created_by',
        'updated_by',
        'uol_date',
        'status_date',
        'date_of_deposit',
        'maturity_date',
        'applied_date',
        'col_date',
        'adventus_id',
        'group_agent',
        'full_fee',
        'scholarship_discount',
        'after_scholarship',
        'case_status',
        'consultancy_fee',

    ];
    protected $table = 'leads';
    public function universities()
    {
        return $this->hasMany(LeadUniversity::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function intake()
    {
        return $this->belongsTo(Intake::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function interview()
    {
        return $this->hasOne(Interview::class);
    }

    public function cas()
    {
        return $this->hasOne(Cas::class);
    }

    public function visaApplpication()
    {
        return $this->hasOne(VisaApplication::class);
    }

    public function visaDecision()
    {
        return $this->hasOne(VisaDecision::class);
    }
}

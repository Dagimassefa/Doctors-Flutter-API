<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'appointment_id',
        'doctor_id',
        'vital_update',
        'case_history',
        'diagnosis',
        'lab_tests',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }


    public function follow_ups()
    {
        return $this->hasMany(FollowUp::class);
    }
}

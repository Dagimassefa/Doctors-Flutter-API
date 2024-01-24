<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
     use HasFactory;

    protected $fillable = [
        'patient_id',
        'patient_name',
        'guardian_name',
        'guardian_phn',
        'gender',
        'marital_status',
        'phone_no',
        'image',
        'email',
        'password',
        'address',
        'age_year',
        'age_month',
        'blood_group',
        'admission_date',
        'patient_case',
        'nationality',
        'religion',
        'reference',
        'consult_doctor',
        'bed_group',
        'bed_no',
        'remarks',
        'status',
        'other_status',
        // 'created_at',  // If you want to allow mass assignment for created_at and updated_at
        // 'updated_at',
    ];

    // Relationships
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }
}

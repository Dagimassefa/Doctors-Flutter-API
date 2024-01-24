<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_name',
        'gender',
        'age',
        'serial_no',
        'phone',
        'clinic',
        'clinic_address',
        'upload_docs',
        'lab_report',
        'prescription',
        'availability_id',
        'status',
        'payment',
        'doctor_id',
    ];

    // Define the relationship with Availability model
    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }
}

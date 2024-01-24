<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'day',
        'type',
        'max_patients',
        'location',
        'phone',
        'address',
        'doctor_id',
        'status',
    ];


public function appointments()
{
    return $this->belongsTo(Appointment::class);
}
}

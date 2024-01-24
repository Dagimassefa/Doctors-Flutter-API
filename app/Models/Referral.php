<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'prescription_id',
        'doctor_name',
        'specialty',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}

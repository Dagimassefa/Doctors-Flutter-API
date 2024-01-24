<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $fillable = [
        'prescription_id',
        'follow_up_date',
        'note',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}

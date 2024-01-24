<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthProfile extends Model
{
    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'blood_pressure',
        'blood_group',
        'sugar',
        'record_date',
    ];

    protected $casts = [
        'record_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

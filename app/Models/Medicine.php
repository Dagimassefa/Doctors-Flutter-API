<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'prescription_id',
        'name',
        'time',
        'quantity',
        'duration',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}

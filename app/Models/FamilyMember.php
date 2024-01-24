<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;
    protected $fillable = [
          'user_id',
        'name',
        'relationship',
        'age',
        'gender',
        'height',
        'weight',
        'blood_pressure',
        'blood_group',
        'sugar',
        'record_date',
        'medicine_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

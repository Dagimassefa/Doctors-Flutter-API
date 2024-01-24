<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRegistration extends Model
{
    use HasFactory;
     protected $primaryKey = 'LabID';
     protected $table = 'LabRegistration';

    protected $fillable = [
        'Region',
        'Zone',
        'District',
        'LabType',
        'TotalCost',
    ];
}

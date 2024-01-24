<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedDiagnosticTests extends Model
{
    use HasFactory;
     protected $primaryKey = 'TestID';
     protected $table = 'BookedDiagnosticTests';

    protected $fillable = [
        'UserID',
        'LabID',
        'SelectedTests',
        'Prescription',
        'Status',
    ];
}

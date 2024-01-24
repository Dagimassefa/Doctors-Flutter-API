<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceVehicle extends Model
{
    use HasFactory;
    protected $table = 'ambulance_vehicle';
      protected $guarded = [];
}

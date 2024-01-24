<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AmbulanceVehicle;
class AmbulanceController extends Controller
{
   public function getAllAmbulances()
    {
        $ambulances = AmbulanceVehicle::all();

        return response()->json(['ambulances' => $ambulances], 200);
    }
     public function getByRegion($region_id)
    {
        $ambulances = AmbulanceVehicle::where('region_id', $region_id)->get();

        return response()->json(['ambulances' => $ambulances], 200);
    }

    public function getByZone($zone_id)
    {
        $ambulances = AmbulanceVehicle::where('zone_id', $zone_id)->get();

        return response()->json(['ambulances' => $ambulances], 200);
    }

    public function getByBranch($branch_id)
    {
        $ambulances = AmbulanceVehicle::where('branch_id', $branch_id)->get();

        return response()->json(['ambulances' => $ambulances], 200);
    }
}

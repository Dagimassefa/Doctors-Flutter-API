<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodDonor;

class BloodDonorController extends Controller
{
      public function index()
    {
        $bloodDonors = BloodDonor::all();
        return response()->json(['bloodDonors' => $bloodDonors], 200);
    }
  public function getByRegion($regionId)
    {
        $bloodDonors = BloodDonor::where('region_id', $regionId)->get();
        return response()->json(['bloodDonors' => $bloodDonors], 200);
    }

    public function getByZone($zoneId)
    {
        $bloodDonors = BloodDonor::where('zone_id', $zoneId)->get();
        return response()->json(['bloodDonors' => $bloodDonors], 200);
    }

    public function getByBranch($branchId)
    {
        $bloodDonors = BloodDonor::where('branch_id', $branchId)->get();
        return response()->json(['bloodDonors' => $bloodDonors], 200);
    }
}

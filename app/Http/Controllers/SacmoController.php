<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sacmo;
class SacmoController extends Controller
{
      public function index()
    {
        $sacmos = Sacmo::all();
        return response()->json(['sacmos' => $sacmos], 200);
    }

    public function show($id)
    {
        $sacmo = Sacmo::find($id);

        if (!$sacmo) {
            return response()->json(['message' => 'Sacmo not found'], 404);
        }

        return response()->json(['sacmo' => $sacmo], 200);
    }

    public function getByDistrict($district_id)
    {
        $sacmos = Sacmo::where('district_id', $district_id)->get();

        return response()->json(['sacmos' => $sacmos], 200);
    }
}

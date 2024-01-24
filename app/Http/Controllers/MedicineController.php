<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MedicineController extends Controller
{
    public function delete(Medicine $medicine)
    {
        $medicine->delete();

        return response()->json(null, 204);
    }
     public function getAllMedicines()
    {
        // Authenticate the user using the Sanctum token
        $user = Auth::user();

        // Check if the user is authenticated
        if ($user) {
            $uniqueMedicines = Medicine::select('name')->distinct()->get();

            return response()->json(['medicines' => $uniqueMedicines], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

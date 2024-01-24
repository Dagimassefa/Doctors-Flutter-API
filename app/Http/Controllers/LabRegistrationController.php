<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabRegistration;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class LabRegistrationController extends Controller
{
     public function store(Request $request)
    {
        $user = auth()->user();

        // Check if the user is authenticated and has user_type = 1 (admin)
        if ($user && $user->user_type === 1) {
            // Validate the incoming request data
            $request->validate([
                'Region' => 'required',
                'Zone' => 'required',
                'District' => 'required',
                'LabType' => 'required',
                'TotalCost' => 'required|numeric',
            ]);

            // Create a new LabRegistration record
            $labRegistration = LabRegistration::create($request->all());

            return response()->json(['message' => 'Lab registration created successfully', 'labRegistration' => $labRegistration], 201);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
     public function edit(Request $request, $labRegistrationId)
    {
        $user = auth()->user();

        // Check if the user is authenticated and has user_type = 1 (admin)
        if ($user && $user->user_type === 1) {
            // Validate the incoming request data
            $request->validate([
                'Region' => 'required',
                'Zone' => 'required',
                'District' => 'required',
                'LabType' => 'required',
                'TotalCost' => 'required|numeric',
            ]);

            // Find the LabRegistration record
            $labRegistration = LabRegistration::findOrFail($labRegistrationId);

            // Update the LabRegistration record
            $labRegistration->update($request->all());

            return response()->json(['message' => 'Lab registration updated successfully', 'labRegistration' => $labRegistration], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

}

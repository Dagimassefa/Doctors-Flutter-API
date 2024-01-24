<?php

namespace App\Http\Controllers;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use App\Models\HealthProfile;

class HealthProfileController extends Controller
{
    public function store(Request $request)
    {
        // Authenticate the user using the Bearer token
        $user = auth()->user();

        // Check if the user is authenticated
        if ($user) {
            // Validate the request data
            $request->validate([
                
                'height' => 'required|numeric',
                'weight' => 'required|numeric',
                'blood_pressure' => 'nullable|string|max:20',
                'blood_group' => 'nullable|string|max:5',
                'sugar' => 'nullable|string|max:20',
                'record_date' => 'required|date',
            ]);

            // Create a new health profile for the authenticated user
            $healthProfile = HealthProfile::create([
                'user_id' => $user->id, // Use the authenticated user's ID
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'blood_pressure' => $request->input('blood_pressure'),
                'blood_group' => $request->input('blood_group'),
                'sugar' => $request->input('sugar'),
                'record_date' => $request->input('record_date'),
            ]);

            return response()->json(['message' => 'Health profile registered successfully', 'data' => $healthProfile], 201);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
    public function editHealthProfile(Request $request, $healthProfileId)
{
    // Authenticate the user using the Bearer token
    $user = auth()->user();

    // Check if the user is authenticated
    if ($user) {
        // Validate the request data
        $request->validate([
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'blood_pressure' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:5',
            'sugar' => 'nullable|string|max:20',
            'record_date' => 'required|date',
        ]);

        // Find the existing health profile
        $healthProfile = HealthProfile::findOrFail($healthProfileId);

        // Check if the authenticated user owns the health profile
        if ($healthProfile->user_id === $user->id) {
            // Update the health profile with the new data
            $healthProfile->update([
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'blood_pressure' => $request->input('blood_pressure'),
                'blood_group' => $request->input('blood_group'),
                'sugar' => $request->input('sugar'),
                'record_date' => $request->input('record_date'),
            ]);

            return response()->json(['message' => 'Health profile updated successfully', 'data' => $healthProfile], 200);
        } else {
            return response()->json(['message' => 'Unauthorized. You do not own this health profile.'], 403);
        }
    }

    return response()->json(['message' => 'Unauthorized'], 401);
}

}

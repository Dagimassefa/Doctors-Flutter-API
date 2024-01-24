<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Traits\ImageUpload;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Hash;
class FamilyMemberController extends Controller
{
   public function addFamilyMember(Request $request, $patientId)
{
    $user = Auth::user();

    if ($user) {
        $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
        ]);

        $familyMember = new FamilyMember([
            'user_id' => $patientId,
            'name' => $request->input('name'),
            'relationship' => $request->input('relationship'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'height' => $request->input('height'),
            'weight' => $request->input('weight'),
            'blood_pressure' => $request->input('blood_pressure'),
            'blood_group' => $request->input('blood_group'),
            'sugar' => $request->input('sugar'),
            'record_date' => $request->input('record_date'),
            'medicine_id' => $request->input('medicine_id'),
        ]);

        $familyMember->save();

        return response()->json(['message' => 'Family member added successfully', 'data' => $familyMember], 201);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
}

   public function editFamilyMember(Request $request, $familyMemberId)
{
    $user = Auth::user();

    if ($user) {
        $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
        ]);

        $familyMember = FamilyMember::findOrFail($familyMemberId);

        $familyMember->update([
            'name' => $request->input('name'),
            'relationship' => $request->input('relationship'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'height' => $request->input('height'),
            'weight' => $request->input('weight'),
            'blood_pressure' => $request->input('blood_pressure'),
            'blood_group' => $request->input('blood_group'),
            'sugar' => $request->input('sugar'),
            'record_date' => $request->input('record_date'),
            'medicine_id' => $request->input('medicine_id'),
        ]);

        return response()->json(['message' => 'Family member updated successfully', 'data' => $familyMember], 200);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
}


}

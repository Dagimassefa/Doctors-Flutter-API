<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookedDiagnosticTests;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class BookedDiagnosticTestsController extends Controller
{
public function store(Request $request)
{
    // Ensure the user is authenticated
    $user = auth()->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Validate the incoming request data
    $request->validate([
        'LabID' => 'required|numeric',
        'SelectedTests' => 'required',
        
    ]);

    // Create a new BookedDiagnosticTests record
    $bookedDiagnosticTest = new BookedDiagnosticTests();
    $bookedDiagnosticTest->UserID = $user->id; // Fill UserID from the authenticated user
    $bookedDiagnosticTest->LabID = $request->input('LabID');
    $bookedDiagnosticTest->SelectedTests = $request->input('SelectedTests');
    $bookedDiagnosticTest->Prescription = $request->input('Prescription');

    if ($request->Prescription) {
        $Prescription = $this->uploadImage($request->Prescription);
        $bookedDiagnosticTest->Prescription = $Prescription;
    }

    // Set the default value for Status to 'Pending'
    $bookedDiagnosticTest->Status = 'Pending';

    $bookedDiagnosticTest->save();

    return response()->json(['message' => 'Diagnostic test booked successfully', 'bookedDiagnosticTest' => $bookedDiagnosticTest], 201);
}
public function edit(Request $request, $bookedDiagnosticTestId)
{
    // Ensure the user is authenticated
    $user = auth()->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Validate the incoming request data
    $request->validate([
        'LabID' => 'required|numeric',
        'SelectedTests' => 'required',
       
    ]);

    // Find the BookedDiagnosticTests record
    $bookedDiagnosticTest = new BookedDiagnosticTests;

    // Check if the authenticated user is the owner of the record
    // if ($user->id !== $bookedDiagnosticTest->UserID) {
    //     return response()->json(['message' => 'Unauthorized to edit this record'], 403);
    // }

    // Update the BookedDiagnosticTests record
    $bookedDiagnosticTest->LabID = $request->input('LabID');
    $bookedDiagnosticTest->SelectedTests = $request->input('SelectedTests');
    $bookedDiagnosticTest->Prescription = $request->input('Prescription');

    if ($request->Prescription) {
        $Prescription = $this->uploadImage($request->Prescription);
        $bookedDiagnosticTest->Prescription = $Prescription;
    }

    $bookedDiagnosticTest->save();

    return response()->json(['message' => 'Diagnostic test updated successfully', 'bookedDiagnosticTest' => $bookedDiagnosticTest], 200);
}



public function uploadImage($file)
{
    try {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $imageName = Str::uuid()->toString() . '.' . $file->extension();
            // Public Folder
            $file->move(public_path('files'), $imageName);
            return $imageName;
        }
        return null; // Or handle the case when $file is not an instance of UploadedFile
    } catch (\Throwable $th) {
        throw $th;
    }
}
}

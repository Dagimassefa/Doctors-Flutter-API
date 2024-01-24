<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Certificate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'phone_no' => 'required|string|unique:doctors',
            'email' => 'required|string|email|max:255|unique:doctors',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $doctor = Doctor::create([

            ...$request->all(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['doctor' => $doctor], 201);
    }


    public function getProfile(Request $request)
    {
        // ensure the request has a valid token
        return response()->json($request->user()->load('zone', 'region', 'branch', 'district', 'division', 'thana', 'union'));
        }

  public function updateProfile(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'gender' => ['required', Rule::in(['male', 'female', 'other'])],
        'phone_no' => ['required', 'string', 'max:15'],
        'email' => ['required', 'string', 'email', 'max:255'],
        // Add validation rules for other fields as needed
    ]);

    // Update the authenticated user's profile
    $user = $request->user();

    // Allow mass assignment for all fields
    $user->forceFill($request->all());

    // Save the changes
    $user->save();

    return response()->json(['message' => 'Profile updated successfully!']);
}


    public function login(Request $request)
    {
        $request->validate([
            'phone_no' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = Doctor::where('phone_no', $request->phone_no)->first();

        if (!$user) {
            return response()->json(
                [
                    'message' => ' incorrect phone and password',
                ],
                400
            );
        }
        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return response()->json(
                [
                    'message' => ' incorrect password',
                ],
                404
            );
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }
    public function updatePassword(Request $request){
        // return $request;
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',

        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json(
                [
                    'message' => ' incorrect credentials ',
                ],
                404
            );
        }

        $check = Hash::check($request->old_password, $user->password);
        if (!$check) {
            return response()->json(
                [
                    'message' => ' incorrect old password ',
                ],
                404
            );
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(
            [
                'message' => 'Successfully  Reset',
            ],
            200
        );

    }


    public function logout(Request $request)
    {
        // Revoke the user's current token
        auth()->user()->currentAccessToken()->delete();

        // Return a response indicating the user is logged out
        return response()->json(['message' => 'Logout successful']);
    }

    public function createCertificate(Request $request, $doctorId)
    {
        $request->validate([
            'url' => 'required|url',
            'title' => 'required|string|max:255',
            'year' => 'required|date_format:Y',
        ]);

        $doctor = Doctor::find($doctorId);
        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        $certificate = new Certificate($request->all());
        $doctor->certificates()->save($certificate);

        return response()->json(['message' => 'Certificate added successfully', 'certificate' => $certificate]);
    }

    public function listCertificates($doctorId)
    {
        $certificates = Certificate::where('doctor_id', $doctorId)->get();
        return response()->json($certificates);
    }
    public function deleteCertificates($certificateId)
    {
        $certificates = Certificate::where('id',$certificateId)->where('doctor_id', auth()->user()->id)->delete();
        return response()->json(null,202);
    }
    public function getDoctorsByTime(Request $request)
    {
        try {
            $time = $request->input('time');

            // Use Eloquent to retrieve all doctors
            $doctors = Doctor::all();

            // Filter doctors whose appointment_day_slot_schedule contains the specified time
            $filteredDoctors = $doctors->filter(function ($doctor) use ($time) {
                $schedule = $doctor->appointment_day_slot_schedule;
                
                // Convert the time to a format that matches the schedule keys
                $formattedTime = date('H:i', strtotime($time));

                return collect($schedule)->contains($formattedTime);
            });

            return response()->json(['doctors' => $filteredDoctors]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

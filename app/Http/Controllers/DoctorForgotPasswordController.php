<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Twilio;

class DoctorForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|exists:doctors',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid phone number'], 400);
        }

        $phoneNo = $request->input('phone_no');

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'phone_no' => $phoneNo,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send the token to the user via SMS
        try {
            Twilio::message($phoneNo, 'Your password reset token: ' . $token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send SMS'.$e], 500);
        }
        return response()->json(['message' => 'Password reset token has been sent']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|exists:users',
            'token' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $phoneNo = $request->input('phone_no');
        $token = $request->input('token');
        $password = $request->input('password');

        $resetRecord = DB::table('password_resets')
            ->where('phone_no', $phoneNo)
            ->latest()
            ->first();

        if (!$resetRecord || !Hash::check($token, $resetRecord->token)) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        // Update the user's password
        User::where('phone_no', $phoneNo)
            ->update(['password' => Hash::make($password)]);

        // Delete the password reset record
        DB::table('password_resets')
            ->where('phone_no', $phoneNo)
            ->delete();

        return response()->json(['message' => 'Password has been reset successfully']);
    }
}

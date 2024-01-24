<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent']);
        } else {
            return response()->json(['message' => 'Unable to send reset link'], 500);
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($doctor, $password) {
                $this->resetPassword($doctor, $password);
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successful']);
        } else {
            return response()->json(['message' => 'Unable to reset password'], 500);
        }
    }

    protected function broker()
    {
        return Password::broker('doctors');
    }

    protected function resetPassword($doctor, $password)
    {
        $doctor->password = Hash::make($password);
        $doctor->save();
    }
}

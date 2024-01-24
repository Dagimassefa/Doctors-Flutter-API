<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            $accessToken = $admin->createToken('adminToken')->accessToken;
            return response()->json(['access_token' => $accessToken]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}

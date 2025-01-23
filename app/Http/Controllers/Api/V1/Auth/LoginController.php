<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function checkLogin(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Email or password is incorrect',
                    'data' => []
                ], 500);
            }
            $token = $user->createToken('hype-shpere')->plainTextToken;
            $cookie = cookie('auth_token', $token, 60);
            return response()->json([
                'status' => 200,
                'message' => 'User logged in successfully',
                'data' => $user,
            ], 200)->cookie($cookie);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->errors(),
                'data' => []
            ], 500);
        }
    }

    public function logout(Request $request) {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => 200,
                'message' => 'User logged out successfully',
                'data' => []
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->errors(),
                'data' => []
            ], 500);
        }
    }
}

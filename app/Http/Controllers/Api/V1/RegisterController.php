<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);


            return response()->json([
                'status' => 200,
                'message' => 'User created successfully',
                'data' => $user,
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->errors(),
                'data' => []
            ], 500);
        }
    }

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
            $tokens = $user->createToken('hype-shpere')->plainTextToken;
            return response()->json([
                'status' => 200,
                'message' => 'User logged in successfully',
                'data' => $user,
                'token' => $tokens
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->errors(),
                'data' => []
            ], 500);
        }
    }
}

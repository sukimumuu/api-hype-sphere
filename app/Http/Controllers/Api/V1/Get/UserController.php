<?php

namespace App\Http\Controllers\Api\V1\Get;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        try {
            $userId = Auth::guard('sanctum')->id();
            $data = User::find($userId);
            if (!$data) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                    'data' => null,
                ], 404);
            }
            return response()->json([
                'status' => 200,
                'message' => 'User fetched successfully',
                'data' => $data,
            ], 200);
        } catch (Exception $e) {
          
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the user data.',
                'error' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Get;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $userId;

    public function __construct() {
        $this->userId = Auth::guard('sanctum')->user()->id;
    }

    public function getUser(Request $request){

        $data = User::find($this->userId);
        try {
            if (!$data) {
                return response()->json([
                    'status' => 500,
                    'message' => 'User not found',
                    'data' => []
                ], 500);
            }
            return response()->json([
                'status' => 200,
                'message' => 'User fetched successfully',
                'data' => $data
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error',
                'data' => []
            ]);
        }
    }
}

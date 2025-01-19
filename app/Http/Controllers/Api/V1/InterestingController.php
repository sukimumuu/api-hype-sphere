<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\InterestingUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InterestingController extends Controller
{
    protected $userId;

    public function __construct() {
        $this->userId = Auth::guard('sanctum')->user()->id;
    }
    public function store(Request $request) {
        try {
            $request->validate([
                'interesting' => 'required|array',
                'interesting.*' => 'string',  
            ]);
            $data = InterestingUser::create([
                'user_id' => $this->userId,
                'interesting' => json_encode($request->interesting)
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'User created successfully',
                'data' => $data
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

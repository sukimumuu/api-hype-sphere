<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;

class SocialiteController extends Controller
{
    public function redirectToProviderGithub() {
        return Socialite::driver('github')->stateless()->redirect();
    }

    public function handleProviderCallbackGithub()
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();
            $user = User::updateOrCreate(
                [
                    'email' => $githubUser->getEmail(),
                ],
                [
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'password' => bcrypt('github_' . $githubUser->getId()),
                ]
            );
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'User authenticated successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Authentication failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

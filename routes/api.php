<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Get\UserController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\InterestingController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\SocialiteController;


Route::prefix('v1')->group(function () {
    
    // AUTH
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/checking-user', [LoginController::class, 'checkLogin']);

    // SOCIALITE
    Route::get('/github/redirect', [SocialiteController::class, 'redirectToProviderGithub']);
    Route::get('/github/callback', [SocialiteController::class, 'handleProviderCallbackGithub']);

    // Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout-user', [LoginController::class, 'logout']);

        // INTERESTING
        Route::post('/interesting', [InterestingController::class, 'store']);

        // USER
        Route::get('/get-user', [UserController::class, 'getUser']);
    // });
});

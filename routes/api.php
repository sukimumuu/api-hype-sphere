<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;


Route::prefix('v1')->group(function () {
    
    // AUTH
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/checking-user', [LoginController::class, 'checkLogin']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout-user', [LoginController::class, 'logout']);
    });
});

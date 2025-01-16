<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RegisterController;


Route::prefix('v1')->group(function () {
    
    // AUTH
    Route::post('/register', [RegisterController::class, 'register']);
});

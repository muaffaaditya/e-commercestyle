<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiCircleController;

/*
|--------------------------------------------------------------------------
| LUXE PREMIUM - API Terminal for Mobile App
|--------------------------------------------------------------------------
*/

// --- PUBLIC ENDPOINTS ---
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);
Route::get('/products', [ApiProductController::class, 'index']);
Route::get('/products/{id}', [ApiProductController::class, 'show']);
Route::get('/home-settings', [ApiProductController::class, 'getHomeSettings']); // Tambahkan ini

// --- PROTECTED ENDPOINTS (Requires Bearer Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // User Identity
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Inner Circle Feature
    Route::get('/inner-circle/messages', [ApiCircleController::class, 'index']);
    Route::post('/subscribe-circle', [ApiCircleController::class, 'subscribe']);

    // Order History
    Route::get('/my-orders', [ApiCircleController::class, 'orderHistory']);

    // Logout
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});
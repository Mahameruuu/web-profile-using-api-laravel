<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KegiatanApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DynamicInputController;
use App\Http\Controllers\Api\DashboardController;

// Route tanpa autentikasi
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/kegiatan', [KegiatanApiController::class, 'index']);

// Route dengan middleware auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Authenticated user
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Kegiatan
    Route::prefix('kegiatan')->group(function () {
        Route::post('/', [KegiatanApiController::class, 'store']);
        Route::get('/{id}', [KegiatanApiController::class, 'show']);
        Route::put('/{id}', [KegiatanApiController::class, 'update']);
        Route::delete('/{id}', [KegiatanApiController::class, 'destroy']);
    });

    // User
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::post('/import', [UserController::class, 'import']);
    });

    // Dynamic Inputs (Fitur)
    Route::prefix('inputs')->group(function () {
        Route::get('/', [DynamicInputController::class, 'index']);
        Route::post('/', [DynamicInputController::class, 'store']);
        Route::get('/{id}', [DynamicInputController::class, 'show']);
        Route::put('/{id}', [DynamicInputController::class, 'update']);
        Route::delete('/{id}', [DynamicInputController::class, 'destroy']);
    });

    // Dashboard summary
    Route::get('/dashboard-summary', [DashboardController::class, 'summary']);
});

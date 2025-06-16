<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KegiatanApiController;
use App\Http\Controllers\Api\AuthController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/kegiatan', [KegiatanApiController::class, 'index']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/kegiatan', [KegiatanApiController::class, 'store']);
    Route::get('/kegiatan/{id}', [KegiatanApiController::class, 'show']);
    Route::put('/kegiatan/{id}', [KegiatanApiController::class, 'update']);
    Route::delete('/kegiatan/{id}', [KegiatanApiController::class, 'destroy']);
});

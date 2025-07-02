<?php

use App\Http\Controllers\UserViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KegiatanViewController;
use App\Http\Controllers\AuthWebController;

// Halaman utama
Route::get('/', [KegiatanViewController::class, 'index'])->name('home');

// Autentikasi
Route::get('/login', [AuthWebController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthWebController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthWebController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthWebController::class, 'logout'])->name('logout');

// Reset Password Manual
Route::get('/reset-password', [AuthWebController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/reset-password', [AuthWebController::class, 'resetPassword'])->name('password.update');

// Dashboard 
Route::get('/dashboard', function () {
    return view('dashboard', ['user' => Auth::user()]);
})->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Kegiatan
    Route::get('/kegiatan', [KegiatanViewController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/create', [KegiatanViewController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanViewController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}/edit', [KegiatanViewController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{id}', [KegiatanViewController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanViewController::class, 'destroy'])->name('kegiatan.destroy');

    // User
    Route::get('/users', [UserViewController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserViewController::class, 'create'])->name('users.create');
    Route::post('/users', [UserViewController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserViewController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserViewController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserViewController::class, 'destroy'])->name('users.destroy');

    // Import Excel
    Route::get('/users/import', [UserViewController::class, 'showImportForm'])->name('users.import.form');
    Route::post('/users/import', [UserViewController::class, 'import'])->name('users.import');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KegiatanViewController;
use App\Http\Controllers\AuthWebController;

Route::get('/', [KegiatanViewController::class, 'index'])->name('home');

Route::get('/login', [AuthWebController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthWebController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthWebController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthWebController::class, 'logout'])->name('logout');
Route::get('/reset-password', [AuthWebController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/reset-password', [AuthWebController::class, 'resetPassword'])->name('password.update');

Route::get('/dashboard', function () {
    if (!session('user')) {
        return redirect()->route('login');
    }
    return view('dashboard', ['user' => session('user')]);
})->name('dashboard');

Route::middleware(['web'])->group(function () {
    Route::get('/kegiatan', [KegiatanViewController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/create', [KegiatanViewController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanViewController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}/edit', [KegiatanViewController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{id}', [KegiatanViewController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanViewController::class, 'destroy'])->name('kegiatan.destroy');
});

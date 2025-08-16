<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [PasswordController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'sendResetLink']);

    Route::get('/reset-password/{token}', [PasswordController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/change-password', [PasswordController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [PasswordController::class, 'changePassword']);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Language switching routes
Route::get('/locale/{locale}', function ($locale) {
    $allowedLocales = ['en', 'ar'];
    
    if (in_array($locale, $allowedLocales)) {
        Session::put('locale', $locale);
        
        if ($locale === 'ar') {
            Cookie::queue('filament_rtl', 'true', 60 * 24 * 365);
            Cookie::queue('html_dir', 'rtl', 60 * 24 * 365);
        } else {
            Cookie::queue('filament_rtl', 'false', 60 * 24 * 365);
            Cookie::queue('html_dir', 'ltr', 60 * 24 * 365);
        }
    }
    
    return redirect()->back();
})->name('locale.switch');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

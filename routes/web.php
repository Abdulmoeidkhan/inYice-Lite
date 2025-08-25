<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\OwnerController;


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('pages.register');
    Route::post('/register', [AuthController::class, 'register'])->name('request.register');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('pages.login');
    Route::post('/login', [AuthController::class, 'login'])->name('request.login');

    Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('request.google');
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('request.googleCallBack');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('request.password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/setup', fn() => view('pages.dashboard'))->name('pages.dashboard'); // Example
    Route::resource('/setup/company', CompanyController::class);
    Route::resource('/setup/owner', OwnerController::class);

    Route::get('/logout', [AuthController::class, 'logout'])->name('request.logout');
});

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('pages.login');
});

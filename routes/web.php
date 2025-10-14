<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{AuthController, CompanyController, OwnerController, SetupDashboardController, AdminDashboardController, EmployeeControler, UsersController};

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
    Route::get('/setup', [SetupDashboardController::class, 'index'])->name('pages.setupDashboard');
    Route::resource('/setup/company', CompanyController::class);
    Route::resource('/setup/owner', OwnerController::class);


    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('pages.adminDashboard');
    Route::resource('/admin/users', UsersController::class)->names([
        'index' => 'pages.admin.users',
        'edit' => 'pages.admin.users.edit',
    ]);

    Route::resource('/admin/employees', EmployeeControler::class)->names([
        'index' => 'pages.admin.employees',
        'edit' => 'pages.admin.employees.edit',
    ]);

    Route::get('/myProfile/{uuid}', [UsersController::class, 'edit'])->name('pages.myProfile');
    Route::get('/about/company', [CompanyController::class, 'index'])->name('pages.aboutCompany');

    Route::get('/dashboard', fn() => view('pages.dashboard'))->name('pages.dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('request.logout');
});

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('pages.login');
});

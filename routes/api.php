<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user()->load('roles', 'permissions');
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Protected routes with permissions
    Route::middleware('permission:view-users')->get('/users', function () {
        return response()->json(['message' => 'Users list']);
    });

    // Protected routes with roles
    Route::middleware('role:admin')->get('/admin/dashboard', function () {
        return response()->json(['message' => 'Admin dashboard']);
    });
    // Image upload route
    Route::middleware('role:admin|owner|developer')->post('/image/upload', [ImageUploadController::class, 'store'])->name('request.imageUpload');
    // It can be also use as resource for all methods
    // Route::middleware('role:admin|owner|developer')->resource('/image/upload', [ImageUploadController::class, 'logout']);
});

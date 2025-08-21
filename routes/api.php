<?php

use App\Http\Controllers\Api\AuthController;
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
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SuperAdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Group Route dengan Middleware Keamanan
Route::middleware(['super_admin'])->group(function () {
    
    // Cek daftar admin
    Route::get('/super/admins', [SuperAdminController::class, 'index']);
    
    // Reset Password
    Route::post('/super/reset-password', [SuperAdminController::class, 'resetPassword']);

});
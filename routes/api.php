<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
});

// User
Route::patch('/user/{id}', [RoleController::class, 'ubahRole'])->middleware(['auth:sanctum', 'can:admin']);
Route::get('/users', [UserController::class, 'index'])->middleware(['auth:sanctum', 'can:admin']);

// Role
Route::post('/role', [RoleController::class, 'tambahRole'])->middleware(['auth:sanctum', 'can:admin']);
Route::get('/roles', [RoleController::class, 'index'])->middleware(['auth:sanctum', 'can:admin']);

// Agenda
Route::post('/agenda', [AgendaController::class, 'buatAgenda']);

Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
    ->middleware('throttle:6,1');

Route::get('/email/verify', [EmailVerificationController::class, 'verify'])
    ->middleware(['throttle:6,1', 'signed'])->name('verification.verify');

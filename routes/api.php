<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacilityImageController;
use App\Http\Controllers\NewsController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
});


// User
Route::patch('/user/{id}', [RoleController::class, 'updateUserRole'])->middleware(['auth:sanctum', 'can:admin']);
Route::get('/users', [UserController::class, 'index'])->middleware(['auth:sanctum', 'can:admin']);

// Role
Route::post('/role', [RoleController::class, 'createRole']); //middleware
Route::get('/roles', [RoleController::class, 'index']); //middleware
Route::patch('/role/{id}', [RoleController::class, 'updateRole']); //middleware
Route::delete('/role/{id}', [RoleController::class, 'deleteRole']); //middleware

Route::get('/email/verify', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('api.verification.verify');

// Email
Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
    ->middleware('throttle:6,1');

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->middleware('throttle:5,1');

Route::post('/reset-password', [PasswordResetController::class, 'reset'])
    ->middleware('throttle:5,1');

// Route::get('/email/verify', [EmailVerificationController::class, 'verify'])
//     ->middleware(['throttle:6,1', 'signed'])->name('verification.verify');

// Agenda
Route::get('/agendas', [AgendaController::class, 'index']);
Route::post('/agenda', [AgendaController::class, 'createAgenda'])->middleware(['auth:sanctum', 'can:admin']); //middleware
Route::patch('/agenda/{id}', [AgendaController::class, 'updateAgenda'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/agenda/{id}', [AgendaController::class, 'deleteAgenda'])->middleware(['auth:sanctum', 'can:admin']); //middleware

// Status
Route::apiResource('/statuses', StatusController::class); // middleware

// Berita
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);
Route::post('/news', [NewsController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']);
Route::patch('/news/{slug}', [NewsController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/news/{slug}', [NewsController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Prestasi
Route::get('/achievements', [AchievementController::class, 'index']);
Route::get('/achievements/{slug}', [AchievementController::class, 'show']);
Route::post('/achievements', [AchievementController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']);
Route::patch('/achievements/{slug}', [AchievementController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/achievements/{slug}', [AchievementController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Fasilitas
Route::get('/facilities', [FacilityController::class, 'index']);
Route::post('/facilities', [FacilityController::class, 'store']);
Route::patch('/facilities/{id}', [FacilityController::class, 'update']);
Route::delete('/facilities/{id}', [FacilityController::class, 'destroy']);

// Gambar Fasilitas
Route::get('/facility-images', [FacilityImageController::class, 'index']);
Route::post('/facility-images', [FacilityImageController::class, 'store']);
Route::put('/facility-images/{id}', [FacilityImageController::class, 'update']);
Route::delete('/facility-images/{id}', [FacilityImageController::class, 'destroy']);

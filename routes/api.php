<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacilityImageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsViewController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
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
Route::post('/role', [RoleController::class, 'createRole'])->middleware(['auth:sanctum', 'can:admin']);
Route::get('/roles', [RoleController::class, 'index'])->middleware(['auth:sanctum', 'can:admin']);
Route::patch('/role/{id}', [RoleController::class, 'updateRole'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/role/{id}', [RoleController::class, 'deleteRole'])->middleware(['auth:sanctum', 'can:admin']);

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
Route::post('/agenda', [AgendaController::class, 'createAgenda'])->middleware(['auth:sanctum', 'can:admin']);
Route::patch('/agenda/{id}', [AgendaController::class, 'updateAgenda'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/agenda/{id}', [AgendaController::class, 'deleteAgenda'])->middleware(['auth:sanctum', 'can:admin']);

// Status
Route::apiResource('/statuses', StatusController::class)->middleware(['auth:sanctum', 'can:admin']); // middleware

// Berita
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);
Route::post('/news', [NewsController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']);
Route::post('/news/{slug}', [NewsController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/news/{slug}', [NewsController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Prestasi
Route::get('/achievements', [AchievementController::class, 'index']);
Route::post('/achievements', [AchievementController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']);
Route::post('/achievements/{id}', [AchievementController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/achievements/{id}', [AchievementController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Fasilitas
Route::get('/facilities', [FacilityController::class, 'index']);
Route::get('/facilities/admin', [FacilityController::class, 'indexAdmin'])->middleware(['auth:sanctum', 'can:admin']);
Route::post('/facilities', [FacilityController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']);
Route::patch('/facilities/{id}', [FacilityController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/facilities/{id}', [FacilityController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Gambar Fasilitas
Route::post('/facility-images', [FacilityImageController::class, 'store']);
Route::post('/facility-images/{id}', [FacilityImageController::class, 'update']);

// Extrakulikuler
Route::get('/extracurricular', [ExtracurricularController::class, 'index']);
Route::get('/extracurricular/admin', [ExtracurricularController::class, 'indexAdmin'])->middleware(['auth:sanctum', 'can:admin']);
Route::post('/extracurricular', [ExtracurricularController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']);
Route::post('/extracurricular/{id}', [ExtracurricularController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/extracurricular/{id}', [ExtracurricularController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Forum
Route::get('/forums', [ForumController::class, 'index']);
Route::get('/forums/admin', [ForumController::class, 'indexAdmin'])->middleware(['auth:sanctum', 'can:admin']);
Route::get('/forums/{id}', [ForumController::class, 'show']);
Route::post('/forums', [ForumController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']);
Route::patch('/forums/{id}', [ForumController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/forums/{id}', [ForumController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Chat
Route::get('/chats', [ChatController::class, 'index']);
Route::post('/chats', [ChatController::class, 'store'])->middleware(['auth:sanctum']); //middleware
Route::patch('/chats/{id}', [ChatController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/chats/{id}', [ChatController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Job Listing
Route::get('/joblisting', [JobListingController::class, 'index']);
Route::post('/joblisting', [JobListingController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']); //middleware
Route::patch('/joblisting/{id}', [JobListingController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/joblisting/{id}', [JobListingController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Job Type
Route::get('/jobtype', [JobTypeController::class, 'index']);

// Feedback
Route::get('/feedback', [FeedbackController::class, 'index'])->middleware(['auth:sanctum', 'can:admin']);
Route::post('/feedback', [FeedbackController::class, 'store']); //middleware
Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// Partner
Route::get('/partner', [PartnerController::class, 'index']);
Route::post('/partner', [PartnerController::class, 'store'])->middleware(['auth:sanctum', 'can:admin']); //middleware
Route::patch('/partner/{id}', [PartnerController::class, 'update'])->middleware(['auth:sanctum', 'can:admin']);
Route::delete('/partner/{id}', [PartnerController::class, 'destroy'])->middleware(['auth:sanctum', 'can:admin']);

// News View
Route::post('/news/{news}/view', [NewsViewController::class, 'store']);

// Test view
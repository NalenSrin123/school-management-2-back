<?php

use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\RoadMapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\UserController;
use App\Models\Role;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileSchoolController;
use App\Http\Controllers\VideoGuideLineController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/google/login', [GoogleLoginController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile-schools', [ProfileSchoolController::class, 'index']);
    Route::post('/profile-schools', [ProfileSchoolController::class, 'store']);
    Route::get('/profile-schools/{id}', [ProfileSchoolController::class, 'show']);
    Route::put('/profile-schools/{id}', [ProfileSchoolController::class, 'update']);
    Route::delete('/profile-schools/{id}', [ProfileSchoolController::class, 'destroy']);
});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //user crud
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    return $request->user();
});


Route::post('/register', [OtpController::class, 'register']);
Route::post('/otp/verify', [OtpController::class, 'verifyOtp']);
Route::post('/otp/resend', [OtpController::class, 'resendOtp']);

Route::apiResource('roadmaps', RoadMapController::class);

Route::apiResource('videoguidelines', VideoGuideLineController::class);


// Courses
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses-most-viewed', [CourseController::class, 'mostViewed']);
Route::get('/courses/{id}', [CourseController::class, 'show']);


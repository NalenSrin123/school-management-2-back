<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Role;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileSchoolController;

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


Route::post('/register', [AuthController::class, 'register']);

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




<?php

use App\Http\Controllers\AnimalVideoController;
use App\Http\Controllers\Api\AnimalsVideoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\SceneController;
use App\Http\Controllers\Api\ObjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get("api_check", [AuthController::class, "api_check"])->name('api_check');

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('forget-password', 'forgetPassword');
    Route::post('verify-otp', 'verifyOtp');
    Route::post('reset-password', 'resetPassword');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('view-user-profile', 'viewProfile');
        Route::post('update-user-profile', 'updateProfile');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
    });

    Route::get('/user/language-edit', [AnimalsVideoController::class, 'languageEdit']);
    Route::post('/user/language-update', [AnimalsVideoController::class, 'languageUpdate']);





});

Route::post('admin/animal-video', [AnimalsVideoController::class, 'animalVideo']);

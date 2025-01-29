<?php

use App\Http\Controllers\AnimalVideoController;
use App\Http\Controllers\SceneController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CreatorController;
use App\Http\Controllers\Admin\TravelPostPlanController;
use App\Http\Controllers\Admin\VerticalController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ReportPostUserController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\SceneAudioController;
use App\Http\Controllers\Admin\LanguageController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('not.logged.in')->group(function () {
    Route::controller(AuthController::class)->prefix('admin')->group(function () {
        Route::get('login', 'loginView')->name('login');
        Route::post('login', 'loginCrediential')->name('login.crediential');
        Route::get('forgot-password', 'forgotPassword')->name('admin.forgotpassword');
        Route::post('reset-forgot-password', 'resetForgotPassword')->name('admin.reset.forgotpassword');
        Route::get('change-password/{token}', 'changePassword')->name('admin.change.password');
        Route::post('store-password', 'storePassword')->name('admin.store.password');
        // Route::post('change-detail', 'changeAdminDetail')->name('admin.change.detail');
        // Route::post('password-reset', 'changeAdminPassword')->name('admin.reset.password');
    });
});

Route::middleware('Authenticated')->group(function () {
    Route::controller(DashboardController::class)->prefix('admin')->group(function () {
        Route::get('dashboard', 'Dashboard')->name('dashboard');
        Route::get('logout', 'logout')->name('logout');
        Route::get('profile', 'profile')->name('profile');
    });

    Route::controller(AuthController::class)->prefix('admin')->group(function () {
        Route::post('change-detail', 'changeAdminDetail')->name('admin.change.detail');
        Route::post('password-reset', 'changeAdminPassword')->name('admin.reset.password');
        //check admin current password
        Route::post('check-current-password', 'checkAdminCurrentPassword')->name('check.admin.current.password');
    });

    Route::controller(UserController::class)->prefix('admin')->group(function () {
        //all are brand routes
        Route::get('user-list', 'userList')->name('user.list');
        Route::post('user-store', 'userStore')->name('user.store');
        // Route::post('user-update', 'userUpdate')->name('user.update');
        Route::post('user-update/{id}', 'userUpdate')->name('user.update');
        Route::delete('user-delete/{id}', 'userDelete')->name('user.delete');
        Route::get('user-profile-update/{id?}', 'userProfileUpdateView')->name('user.profile.update.view');
        Route::post('user-profile-update/{id?}', 'userProfileUpdate')->name('user.profile.update');

        //user already exists
        Route::post('check-email', 'emailExistsOrNote')->name('check.email');
        //upload admin profile image
        Route::post('update-admin-profile', 'updateAdminProfile')->name('update.admin.profile');
        //user status change
        Route::post('user-status-change', 'userStatusChange')->name('user.status.change');

    });
    Route::controller(PagesController::class)->prefix('admin/pages')->group(function () {
        Route::get('/', 'pages')->name('pages');
        Route::get('privacy-policy', 'privacyPolicy')->name('privacy.policy');
        Route::post('privacy-policy-edit', 'privacyPolicyEdit')->name('privacy.policy.edit');
        Route::get('terms-conditions', 'termsConditions')->name('terms.conditions');
        Route::post('terms-conditions-edit', 'termsConditionsEdit')->name('terms.conditions.edit');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/animal-videos', [AnimalVideoController::class, 'index'])->name('animal.videos');
        Route::post('/animal-videos', [AnimalVideoController::class, 'create'])->name('animal.videos.create');


        Route::get('/animal-videos-edit/{id}', [AnimalVideoController::class, 'edit'])->name('animal.videos.edit');
        Route::post('/animal-videos-update/{id}', [AnimalVideoController::class, 'update'])->name('animal.videos.update');

        Route::delete('/animal-videos-delete/{id}', [AnimalVideoController::class, 'delete'])->name('animal.videos.delete');


    });



    Route::prefix('admin')->group(function () {
        Route::get('/scene-audio', [SceneAudioController::class, 'index'])->name('scene.index');
        Route::post('/scene-audio', [SceneAudioController::class, 'create'])->name('scene.create');

        Route::get('/scene-audio-edit/{id}', [SceneAudioController::class, 'edit'])->name('scene.edit');
        Route::post('/scene-audio-update/{id}', [SceneAudioController::class, 'update'])->name('scene.update');

        Route::delete('/scene-audio-delete/{id}', [SceneAudioController::class, 'delete'])->name('scene.delete');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/languages', [LanguageController::class, 'index'])->name('language.index');
        Route::post('/create-languages', [LanguageController::class, 'store'])->name('language.store');
        Route::get('/languages/{id}/edit', [LanguageController::class, 'edit'])->name('language.edit');
        Route::post('/languages/{id}', [LanguageController::class, 'update'])->name('language.update');
        Route::delete('/languages/{id}', [LanguageController::class, 'destroy'])->name('language.destroy');
    });



    // Route::resource('scenes', SceneController::class);


});
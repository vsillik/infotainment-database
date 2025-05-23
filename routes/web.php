<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfotainmentController;
use App\Http\Controllers\InfotainmentManufacturerController;
use App\Http\Controllers\InfotainmentProfileController;
use App\Http\Controllers\SerializerManufacturerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'approved'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(UserProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::get('/profile/password', 'editPassword')->name('profile.password.edit');
        Route::patch('/profile/password', 'updatePassword')->name('profile.password.update');
    });

    Route::resource('infotainment_manufacturers', InfotainmentManufacturerController::class);

    Route::resource('serializer_manufacturers', SerializerManufacturerController::class);

    Route::controller(InfotainmentController::class)->group(function () {
        Route::get('/infotainments/assign', 'assignUsers')->name('infotainments.assign');
        Route::patch('/infotainments/assign/add', 'addAssignedUsers')->name('infotainments.assign.add');
    });

    Route::resource('infotainments', InfotainmentController::class);

    Route::resource('infotainments.profiles', InfotainmentProfileController::class)
        ->except(['index']);

    Route::controller(InfotainmentProfileController::class)->group(function () {
        Route::get('/infotainments/{infotainment}/profiles/{profile}/approve', 'approve')->name('infotainments.profiles.approve');
        Route::get('/infotainments/{infotainment}/profiles/{profile}/copy', 'copy')->name('infotainments.profiles.copy');
        Route::get('/infotainments/{infotainment}/profiles/{profile}/download', 'downloadEdid')->name('infotainments.profiles.download');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users/deleted', 'indexDeleted')->name('users.deleted');
        Route::patch('/users/{user}/restore', 'restore')->withTrashed()->name('users.restore');
        Route::delete('/users/{user}/force-destroy', 'forceDestroy')->withTrashed()->name('users.force-destroy');
        Route::get('/users/{user}/approve', 'approve')->name('users.approve');
        Route::get('/users/{user}/unapprove', 'unapprove')->name('users.unapprove');
        Route::get('/users/{user}/assign-infotainments', 'assignInfotainments')->name('users.assign-infotainments');
        Route::patch('/users/{user}/assign-infotainments', 'updateAssignedInfotainments')->name('users.assign-infotainments.update');
    });

    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';

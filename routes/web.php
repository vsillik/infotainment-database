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

    Route::resource('infotainment_manufacturers', InfotainmentManufacturerController::class)
        ->except(['show']);

    Route::resource('serializer_manufacturers', SerializerManufacturerController::class)
        ->except(['show']);

    Route::resource('infotainments', InfotainmentController::class);

    Route::resource('infotainments.profiles', InfotainmentProfileController::class)
        ->except(['show', 'index']);

    Route::controller(InfotainmentProfileController::class)->group(function () {
        Route::get('/infotainments/{infotainment}/profiles/{profile}/approve', 'approve')->name('infotainments.profiles.approve');
        Route::get('/infotainments/{infotainment}/profiles/{profile}/copy', 'copy')->name('infotainments.profiles.copy');
    });

    Route::resource('users', UserController::class)
        ->except(['show']);

    Route::controller(UserController::class)->group(function () {
        Route::get('/users/{user}/approve', 'approve')->name('users.approve');
        Route::get('/users/{user}/unapprove', 'unapprove')->name('users.unapprove');
    });
});


require __DIR__.'/auth.php';

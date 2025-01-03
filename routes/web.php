<?php

use App\Http\Controllers\InfotainmentController;
use App\Http\Controllers\InfotainmentManufacturerController;
use App\Http\Controllers\InfotainmentProfileController;
use App\Http\Controllers\SerializerManufacturerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

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

require __DIR__.'/auth.php';

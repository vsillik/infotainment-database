<?php

use App\Http\Controllers\InfotainmentManufacturerController;
use App\Http\Controllers\SerializerManufacturerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::resource('infotainment_manufacturers', InfotainmentManufacturerController::class)
    ->except(['show']);

Route::resource('serializer_manufacturers', SerializerManufacturerController::class)
    ->except(['show']);

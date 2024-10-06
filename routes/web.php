<?php

use App\Http\Controllers\InfotainmentManufacturerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::resource('infotainment_manufacturers', InfotainmentManufacturerController::class)
    ->except(['show']);

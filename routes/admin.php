<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\LocalityController;
use App\Http\Controllers\Admin\AmenityController;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Property management CRUD (accessible by admin and agent due to web.php role:admin|agent middleware)
Route::resource('properties', PropertyController::class);
Route::post('properties/{property}/verify', [PropertyController::class, 'verify'])->name('properties.verify');

// Locality & Amenity management (Only accessible by admin role)
Route::middleware('role:admin')->group(function () {
    Route::resource('localities', LocalityController::class);
    Route::resource('amenities', AmenityController::class);
});

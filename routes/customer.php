<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Customer\VisitRequestController;

Route::get('/dashboard', function () {
    $visitRequests = auth()->user()->visitRequests()
        ->with(['property.locality', 'agent', 'review', 'deal'])
        ->latest()
        ->get();
    return view('customer.dashboard', compact('visitRequests'));
})->name('dashboard');

Route::post('/visits', [VisitRequestController::class, 'store'])->name('visits.store');

// Customer Deal Invoice Access
Route::get('/deals/{deal}/invoice', [\App\Http\Controllers\Agent\DealController::class, 'invoice'])->name('deals.invoice');

// Feedback & Reviews
Route::get('/visits/{visit}/review', [\App\Http\Controllers\Customer\ReviewController::class, 'create'])->name('reviews.create');
Route::post('/visits/{visit}/review', [\App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('reviews.store');

// Property Listing (Frontend Multi-step)
Route::get('/properties/create', [\App\Http\Controllers\Customer\PropertyListingController::class, 'create'])->name('properties.create');
Route::post('/properties/step', [\App\Http\Controllers\Customer\PropertyListingController::class, 'storeStep'])->name('properties.store-step');
Route::post('/properties/upload-image', [\App\Http\Controllers\Customer\PropertyListingController::class, 'uploadImage'])->name('properties.upload-image');

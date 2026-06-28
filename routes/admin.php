<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\LocalityController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Property management CRUD (accessible by admin and agent due to web.php role:admin|agent middleware)
Route::resource('properties', PropertyController::class);
Route::post('properties/{property}/verify', [PropertyController::class, 'verify'])->name('properties.verify');

// Locality & Amenity management (Only accessible by admin role)
Route::middleware('role:admin')->group(function () {
    Route::resource('localities', LocalityController::class);
    Route::resource('amenities', AmenityController::class);
    Route::resource('agents', AgentController::class);
    Route::get('visits', [VisitController::class, 'index'])->name('visits.index');
    Route::post('visits/{visit}/assign', [VisitController::class, 'assign'])->name('visits.assign');
    
    // Deal Invoices & Payments (Admin view & management)
    Route::get('deals/{deal}/invoice', [\App\Http\Controllers\Agent\DealController::class, 'invoice'])->name('deals.invoice');
    Route::post('deals/{deal}/payment-status', [\App\Http\Controllers\Agent\DealController::class, 'updatePaymentStatus'])->name('deals.payment-status');
});

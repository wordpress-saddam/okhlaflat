<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Customer\VisitRequestController;

Route::get('/dashboard', function () {
    $visitRequests = auth()->user()->visitRequests()
        ->with('property.locality', 'agent')
        ->latest()
        ->get();
    return view('customer.dashboard', compact('visitRequests'));
})->name('dashboard');

Route::post('/visits', [VisitRequestController::class, 'store'])->name('visits.store');

// Customer Deal Invoice Access
Route::get('/deals/{deal}/invoice', [\App\Http\Controllers\Agent\DealController::class, 'invoice'])->name('deals.invoice');

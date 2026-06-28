<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Agent\VisitAssignmentController;
use App\Http\Controllers\Agent\DealController;

Route::get('/dashboard', function () {
    return view('agent.dashboard');
})->name('dashboard');

Route::get('/visits', [VisitAssignmentController::class, 'index'])->name('visits.index');
Route::put('/visits/{visit}', [VisitAssignmentController::class, 'updateStatus'])->name('visits.update');

// Deal Closing & Invoicing
Route::get('/visits/{visit}/close', [DealController::class, 'create'])->name('deals.create');
Route::post('/deals', [DealController::class, 'store'])->name('deals.store');
Route::get('/deals/{deal}/invoice', [DealController::class, 'invoice'])->name('deals.invoice');

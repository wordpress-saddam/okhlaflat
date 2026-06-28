<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Agent\VisitAssignmentController;

Route::get('/dashboard', function () {
    return view('agent.dashboard');
})->name('dashboard');

Route::get('/visits', [VisitAssignmentController::class, 'index'])->name('visits.index');
Route::put('/visits/{visit}', [VisitAssignmentController::class, 'updateStatus'])->name('visits.update');

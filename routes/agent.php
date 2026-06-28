<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('agent.dashboard');
})->name('dashboard');

// Agent specific routes for leads, visit schedules, notes will be added here

<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('customer.dashboard');
})->name('dashboard');

// Customer specific routes for favorites, bookings will be added here

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Frontend Routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

use App\Http\Controllers\PropertyController as PublicPropertyController;

Route::get('/properties', [PublicPropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:property_code}', [PublicPropertyController::class, 'show'])->name('properties.show');

// Main Dashboard Redirection based on Role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('agent')) {
        return redirect()->route('agent.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (default Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authenticated Role-based Portals
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin & Agent routes
    Route::middleware(['role:admin|agent'])
        ->prefix('admin')
        ->name('admin.')
        ->group(__DIR__.'/admin.php');

    // Agent routes
    Route::middleware(['role:agent'])
        ->prefix('agent')
        ->name('agent.')
        ->group(__DIR__.'/agent.php');

    // Customer routes
    Route::middleware(['role:customer'])
        ->prefix('customer')
        ->name('customer.')
        ->group(__DIR__.'/customer.php');
});

require __DIR__.'/auth.php';

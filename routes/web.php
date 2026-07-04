<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminFlightController;
use App\Http\Controllers\AdminBookingController;

// Customer Portal & Flight Search (Homepage)
Route::get('/', [FlightController::class, 'search'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Book Flight & Profile (Protected by Auth)
Route::middleware('auth')->group(function () {
    Route::post('/flights/{flight}/book', [FlightController::class, 'book'])->name('flights.book');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

// Admin Panel (Protected by Auth and Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Flight CRUD
    Route::resource('flights', AdminFlightController::class);
    
    // Booking management
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');
});
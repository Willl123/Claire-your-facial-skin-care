<?php

use Illuminate\Support\Facades\Route;
use App\Models\Booking;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TherapistController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $notifications = Booking::where('status', 'pending')
        ->latest()
        ->get();

    return view('welcome', compact('notifications'));

});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'authenticate']);

    Route::get('/register', [AuthController::class, 'showRegister']);

    Route::post('/register', [AuthController::class, 'register']);

});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index']);

    Route::get('/booking/{id}/approve', [BookingController::class, 'approve']);

    Route::get('/booking/{id}/reject', [BookingController::class, 'reject']);

    Route::get('/booking/{id}/complete', [BookingController::class, 'complete']);

    Route::get('/notifications', [BookingController::class, 'notifications']);

    Route::post('/notifications/{id}/hide', [BookingController::class, 'hide'])
        ->name('notifications.hide');

});

/*
|--------------------------------------------------------------------------
| Customer
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/profile', [CustomerController::class, 'profile'])
        ->name('profile');

    Route::get('/booking', function () {
        return view('booking');
    });

    Route::post('/booking/store', [BookingController::class, 'store']);

    Route::post('/profile/photo', [CustomerController::class, 'uploadPhoto'])
        ->name('profile.photo');

          Route::get('/notifications', [BookingController::class, 'notifications'])
        ->name('notifications');

    Route::post('/notifications/{id}/hide', [BookingController::class, 'hide'])
        ->name('notifications.hide');

});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


    /*
|--------------------------------------------------------------------------
| Therapist
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:therapist'])->group(function () {

    Route::get('/therapist', [TherapistController::class, 'index'])
        ->name('therapist.dashboard');

});

Route::post('/booking/{id}/assign-therapist', [BookingController::class, 'assignTherapist'])
    ->name('booking.assignTherapist');
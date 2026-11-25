
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

    // Dashboard Admin
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    // Jadwal Terapis
    Route::get('/admin/therapist-schedules', [AdminController::class, 'therapistSchedules'])
        ->name('admin.therapistSchedules');

    // Menyetujui penugasan terapis
    Route::post('/booking/{id}/approve', [BookingController::class, 'approve'])
        ->name('booking.approve');

    // Menolak penugasan terapis
    Route::post('/booking/{id}/reject-assignment', [BookingController::class, 'rejectAssignment'])
        ->name('booking.rejectAssignment');

    // Menolak pesanan customer
    Route::post('/booking/{id}/reject', [BookingController::class, 'reject'])
        ->name('booking.reject');

    // Menugaskan terapis
    Route::post('/booking/{id}/assign-therapist', [BookingController::class, 'assignTherapist'])
        ->name('booking.assignTherapist');

    // Notifikasi Admin
    Route::get('/admin/notifications', [BookingController::class, 'notifications'])
        ->name('admin.notifications');

    // Profil Admin
    Route::get('/admin/profile', [CustomerController::class, 'adminProfile'])
        ->name('admin.profile');

    Route::post('/admin/profile/photo', [CustomerController::class, 'uploadAdminPhoto'])
        ->name('admin.profile.photo');


    Route::get('/admin/bookings/{booking}/row', [AdminController::class, 'bookingRow'])
        ->name('admin.bookings.row');
});





/*
|--------------------------------------------------------------------------
| Customer
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])->group(function () {

    // Dashboard Customer
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('customer.dashboard');

    // Profil
    Route::get('/profile', [CustomerController::class, 'profile'])
        ->name('profile');

    Route::post('/profile/photo', [CustomerController::class, 'uploadPhoto'])
        ->name('profile.photo');

    // Booking
    Route::get('/booking', function () {
        return view('booking');
    })->name('booking');

    Route::post('/booking/store', [BookingController::class, 'store'])
        ->name('booking.store');

    // Notifikasi Customer
    Route::get('/notifications', [BookingController::class, 'notifications'])
        ->name('notifications');

    Route::post('/notifications/{id}/hide', [BookingController::class, 'hide'])
        ->name('notifications.hide');
});


/*
|--------------------------------------------------------------------------
| Therapist
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:therapist'])->group(function () {

    // Dashboard Terapis
    Route::get('/therapist', [TherapistController::class, 'index'])
        ->name('therapist.dashboard');

    // Mengaktifkan / menonaktifkan ketersediaan
    Route::post('/therapist/toggle-availability', [TherapistController::class, 'toggleAvailability'])
        ->name('therapist.toggleAvailability');

    // Menerima penugasan
    Route::post('/therapist/assignment/{id}/accept', [TherapistController::class, 'acceptAssignment'])
        ->name('therapist.assignment.accept');

    // Menolak penugasan
    Route::post('/therapist/assignment/{id}/reject', [TherapistController::class, 'rejectAssignment'])
        ->name('therapist.assignment.reject');

    // Menyelesaikan treatment
    Route::post('/therapist/assignment/{id}/complete', [TherapistController::class, 'complete'])
        ->name('therapist.assignment.complete');


    // Profil Worker
    Route::get('/therapist/profile', [CustomerController::class, 'therapistProfile'])
        ->name('therapist.profile');

    Route::post('/therapist/profile/photo', [CustomerController::class, 'uploadTherapistPhoto'])
        ->name('therapist.profile.photo');
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

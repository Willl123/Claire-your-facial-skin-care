

<?php

use Illuminate\Support\Facades\Route;

use App\Models\Booking;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;

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
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/register', [AuthController::class, 'showRegister']);

Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Customer
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/profile', [CustomerController::class, 'profile'])
    ->name('profile');

/*
|--------------------------------------------------------------------------
| Booking
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/booking', function () {
        return view('booking');
    });

    Route::post('/booking/store', [BookingController::class, 'store']);

});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::get('/admin', [AdminController::class, 'index']);

Route::get('/booking/{id}/approve', [BookingController::class, 'approve']);

Route::get('/booking/{id}/reject', [BookingController::class, 'reject']);

Route::get('/booking/{id}/complete', [BookingController::class, 'complete']);

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::get('/notifications', [BookingController::class, 'notifications']);

Route::post('/notifications/{id}/hide', [BookingController::class, 'hide'])
    ->name('notifications.hide');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::post('/profile/photo', [CustomerController::class, 'uploadPhoto'])
    ->name('profile.photo');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('welcome');
// });

// /*
// |--------------------------------------------------------------------------
// | Auth
// |--------------------------------------------------------------------------
// */

// // Route::get('/login', [AuthController::class,'login']);

// // Route::post('/login', [AuthController::class,'authenticate']);

// Route::get('/register', [AuthController::class,'showRegister']);

// Route::post('/register', [AuthController::class,'register']);

// /*
// |--------------------------------------------------------------------------
// | Customer
// |--------------------------------------------------------------------------
// */

// // Route::get('/dashboard', function () {

// //     return view('welcome');

// // });

// use App\Http\Controllers\DashboardController;

// Route::get('/dashboard', [DashboardController::class, 'index']);

// /*
// |--------------------------------------------------------------------------
// | Admin
// |--------------------------------------------------------------------------
// */

// use App\Http\Controllers\AdminController;

// Route::get('/admin', [AdminController::class, 'index']);

// /*
// |--------------------------------------------------------------------------
// | Booking
// |--------------------------------------------------------------------------
// */

// Route::middleware('auth')->group(function () {

//     Route::get('/booking', function () {
//         return view('booking');
//     });

// });

// Route::get('/profile', function () {
//     return view('profile');
// })->name('profile');

// use App\Http\Controllers\CustomerController;

// Route::get('/profile', [CustomerController::class, 'profile'])
//     ->name('profile');

// Route::post('/logout', [AuthController::class, 'logout'])
//     ->name('logout');



// Route::get('/login',[AuthController::class,'login'])
// ->name('login');

// Route::post('/login',
// [AuthController::class,'authenticate']);



// use App\Http\Controllers\BookingController;

// Route::post(
//     '/booking/store',
//     [BookingController::class,'store']
// );

// Route::get(
//     '/booking/{id}/approve',
//     [BookingController::class,'approve']
// );

// Route::get(
//     '/booking/{id}/reject',
//     [BookingController::class,'reject']
// );

// Route::get(
//     '/booking/{id}/complete',
//     [BookingController::class,'complete']
// );

// // Route::get('/customer/dashboard', [CustomerController::class, 'dashboard']);
// // Route::get('/customer/booking/{id}', [CustomerController::class, 'detail']);
// // Route::get('/customer/notifications', [CustomerController::class, 'notifications']);

// // Route::get('/notifications', [BookingController::class, 'notifications']);
// // Route::post('/notifications/{id}/hide', [BookingController::class, 'hide']);



// Route::get('/notifications', [BookingController::class, 'notifications']);

// Route::post('/notifications/{id}/hide', [BookingController::class, 'hide'])
//     ->name('notifications.hide');


//     Route::post('/profile/photo', [CustomerController::class,'uploadPhoto'])
//     ->name('profile.photo');

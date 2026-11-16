<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
{
    View::composer(['dashboard', 'notifications', 'customer.*'], function ($view) {

        if (Auth::check()) {
            $view->with('bookings',
                Booking::where('user_id', Auth::id())
                    ->where('is_hidden', 0)
                    ->latest()
                    ->get()
            );
        }

    });
}
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;


class AuthController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make(
                $request->password
            ),

            'role' => 'customer'

        ]);

        return redirect('/login');
    }
    
        public function authenticate(Request $request)
    {
        $credentials = $request->only(
            'email',
            'password'
        );

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            if(Auth::user()->role == 'admin')
            {
                return redirect('/admin');
            }

            return redirect('/dashboard');
        }

        return back()->with(
            'error',
            'Email atau Password salah'
        );
    }


    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }





    public function store(Request $request)
    {
        Booking::create([

            'user_id' => Auth::id(),

            'treatment' => $request->treatment,

            'booking_date' => $request->booking_date,

            'booking_time' => $request->booking_time,

            'notes' => $request->notes,

            'status' => 'pending'

        ]);

        return redirect('/dashboard');
    }


    public function bookings()
    {
        $bookings = Booking::latest()->get();

        return view(
            'admin.bookings',
            compact('bookings')
        );
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'approved';

        $booking->save();

        return back();
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'rejected';

        $booking->save();

        return back();
    }


    public function dashboard()
    {
        $bookings = Booking::where('user_id', auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.dashboard', compact('bookings'));
    }

    public function detail($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth::id())
            ->firstOrFail();

        return view('customer.detail', compact('booking'));
    }

    public function notifications()
    {
        $bookings = Booking::where('user_id', auth::id())
            ->whereIn('status', ['approved','rejected','completed'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('customer.notifications', compact('bookings'));
    }

    public function destroy($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth::id())
            ->firstOrFail();

        $booking->update([
            'is_hidden' => true
        ]);

        return back();
    }




}
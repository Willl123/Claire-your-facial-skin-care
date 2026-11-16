<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class CustomerController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);
    
        /** @var User $user */
        $user = Auth::user();
    
        if ($request->hasFile('photo')) {
    
            $file = $request->file('photo');
    
            $path = $file->store('profiles', 'public');
    
            $user->photo = $path;
            $user->save();
        }
    
        return back();
    }

    public function profile()
    {
        $user = Auth::user();

        $totalBooking = \App\Models\Booking::where('user_id',$user->id)->count();

        $completedBooking = \App\Models\Booking::where('user_id',$user->id)
            ->where('status','completed')
            ->count();

        $pendingBooking = \App\Models\Booking::where('user_id',$user->id)
            ->where('status','pending')
            ->count();

        return view('profile', compact(
            'totalBooking',
            'completedBooking',
            'pendingBooking'
        ));
    }


}
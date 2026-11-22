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

        $totalBooking = \App\Models\Booking::where('user_id', $user->id)->count();

        $completedBooking = \App\Models\Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $pendingBooking = \App\Models\Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('profile', compact(
            'totalBooking',
            'completedBooking',
            'pendingBooking'
        ));
    }



    // PROFIL ADMIN
    public function adminProfile()
    {
        $user = Auth::user();

        return view('profiladmin', [
            'user' => $user,
            'roleLabel' => 'Administrator',
            'dashboardUrl' => route('admin.dashboard'),
            'photoRoute' => 'admin.profile.photo',
        ]);
    }

    // PROFIL WORKER / TERAPIS
    public function therapistProfile()
    {
        $user = Auth::user();

        return view('profilworker', [
            'user' => $user,
            'roleLabel' => 'Therapist',
            'dashboardUrl' => route('therapist.dashboard'),
            'photoRoute' => 'therapist.profile.photo',
        ]);
    }

    // UPLOAD FOTO ADMIN
    public function uploadAdminPhoto(Request $request)
    {
        return $this->savePhoto($request);
    }

    // UPLOAD FOTO WORKER
    public function uploadTherapistPhoto(Request $request)
    {
        return $this->savePhoto($request);
    }

    // PROSES SIMPAN FOTO
    private function savePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {

            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru
            $path = $request->file('photo')->store('profiles', 'public');

            $user->photo = $path;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}

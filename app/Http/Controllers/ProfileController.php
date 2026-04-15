<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input dasar
        $request->validate([
            'first_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // maksimal 2MB
        ]);

        $dataToUpdate = [
            'name' => $request->first_name, // Menggunakan column bawaan laravel untuk kemudahan auth
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'degree' => $request->degree,
            'designation' => $request->designation,
            'address' => $request->address,
            'about' => $request->about,
            'education' => $request->education,
            'experience' => $request->experience,
        ];

        // Jika user memilih file untuk diunggah
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Simpan avatar baru
            $avatarFile = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatarFile->getClientOriginalExtension();
            $avatarFile->storeAs('avatars', $avatarName, 'public');

            $dataToUpdate['avatar'] = $avatarName;
        }

        // Update data ke database
        $user->update($dataToUpdate);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}

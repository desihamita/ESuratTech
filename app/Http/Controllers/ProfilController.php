<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Profile';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'User Profil', 'url' => ''],
        ];

        return view('pages.profil.index', compact('title', 'breadcrumbs') );
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $originalNameWithoutExtension = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFileName = date('Y_m_d') . '_' . $originalNameWithoutExtension . '.' . $extension;
            $file->move(public_path('uploads/profile'), $newFileName);

            // Simpan nama file ke dalam database
            $user->profile_picture = $newFileName;
        }
        // \dd($user);

        $user->update();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_picture && file_exists(public_path('uploads/profile/' . $user->profile_picture))) {
            unlink(public_path('uploads/profile/' . $user->profile_picture));
        }

        $user->profile_picture = null;
        $user->save();

        return redirect()->back()->with('success', 'Photo deleted successfully.');
    }


}

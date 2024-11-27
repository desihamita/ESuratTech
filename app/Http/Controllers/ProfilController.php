<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\Division;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Profile';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'User Profil', 'url' => ''],
        ];
        $data = Classification::all();

        return view('pages.profil.index', compact('data','title', 'breadcrumbs') );
    }

    public function indexDatatable()
    {
        $title = 'Manajemen User';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Manajemen User', 'url' => ''],
        ];
        $data = User::with('division')->get();
        $divisions = Division::all();
        return view('pages.kelola_pengguna.index', compact('data', 'divisions', 'title', 'breadcrumbs') );
    }

    public function store(Request $request)
    {
        // \dd($request);
        // Validasi data
        $request->validate([
            'nip' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'division_kode' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,inactive',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Insert data ke tabel users
        $user = User::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'division_kode' => $request->division_kode,
            'status' => $request->status ?? 'inactive',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        // \dd($request);
        $request->validate([
            'nip' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'division_kode' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,inactive',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user->nip=$request->nip;
        $user->name = $request->name;
        $user->jabatan = $request->jabatan;
        $user->division_kode = $request->division_kode;
        $user->status = $request->status ?? 'inactive';
        $user->email = $request->email;


        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $originalNameWithoutExtension = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFileName = date('Y_m_d') . '_' . $originalNameWithoutExtension . '.' . $extension;
            $file->move(public_path('uploads/profile'), $newFileName);

            // Simpan name file ke dalam database
            $user->profile_picture = $newFileName;
        }

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

        return redirect()->back()->with('success', 'Photo Berhasil Dihapus.');
    }

    public function destroy(string $id)
    {
        // \dd($id);
        try{
            $user = User::find($id);
            $user->delete();
            return redirect()->back()->with('success', 'User Berhasil Dihapus.');
        } catch(Exception $e){
            return redirect()->back()->with('error', 'User Tidak Ditemukan.');
        }


    }

}

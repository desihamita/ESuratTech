<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembaga;

class LembagaController extends Controller
{
    public function edit()
    {
        $lembaga = Lembaga::findOrFail(2);
        $title = 'Lembaga';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Lembaga', 'url' => ''],
        ];

        return view('pages.lembaga.index', compact('lembaga', 'title', 'breadcrumbs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'website' => 'nullable|',
            'email' => 'nullable|email',
            'alamat' => 'nullable|string|max:255',
            'tahun' => 'required|integer',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kepala' => 'required|string|max:100',
            'nip' => 'required|string|max:20',
            'jabatan' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Cari lembaga dengan ID 2
        $lembaga = Lembaga::findOrFail(2);
    
        // Update data lembaga
        $lembaga->nama_lembaga = $request->nama_lembaga;
        $lembaga->telepon = $request->telepon;
        $lembaga->website = $request->website;
        $lembaga->email = $request->email;
        $lembaga->alamat = $request->alamat;
        $lembaga->tahun = $request->tahun;
        $lembaga->kota = $request->kota;
        $lembaga->provinsi = $request->provinsi;
        $lembaga->kepala = $request->kepala;
        $lembaga->nip = $request->nip;
        $lembaga->jabatan = $request->jabatan;
    
        // Simpan perubahan ke database
        $lembaga->save();
    
        // Redirect kembali ke halaman edit lembaga dengan pesan sukses
        return redirect()->route('lembaga.edit')->with('success', 'Lembaga updated successfully.');
    }
    
    public function updateLogo(Request $request)
    {
        $lembaga = Lembaga::findOrFail(2);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $originalNameWithoutExtension = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFileName = date('Y_m_d') . '_' . $originalNameWithoutExtension . '.' . $extension;
            $file->move(public_path('uploads/lembaga'), $newFileName);
    
            // Simpan nama file logo ke database
            $lembaga->logo = $newFileName;
        }
    
        // Simpan perubahan ke database
        $lembaga->save();
        return redirect()->route('lembaga.edit')->with('success', 'Lembaga updated successfully.');
    }
}

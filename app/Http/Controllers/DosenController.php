<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosenPromotion;
use Illuminate\Support\Facades\Validator;


class DosenController extends Controller
{
    public function index()
    {
        $title = 'Surat Dosen';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Dosen', 'url' => ''],
        ];
        
        return view('pages.dosen.index', compact('title', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_dosen' => 'required',
            'jabatan_akademik_sebelumnya' => 'required',
            'jabatan_akademik_di_usulkan' => 'required',
            'tanggal_proses' => 'required',  
            'tanggal_selesai' => 'required', 
            'surat_pengantar_pimpinan_pts' => 'required|file|mimetypes:application/pdf|max:2048',
            'berita_acara_senat' => 'required|file|mimetypes:application/pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $savedFilePath = null;
            $savedFilePathBerita = null;
            if ($request->hasFile('surat_pengantar_pimpinan_pts')) {
                $savedFilePath = $request->file('surat_pengantar_pimpinan_pts')->store('surat_pengantar', 'public');
            } 
            
            if ($request->hasFile('berita_acara_senat')) {
                $savedFilePathBerita = $request->file('berita_acara_senat')->store('berita_acara', 'public');
            }

            DosenPromotion::create([
                'nama_dosen' => $request->nama_dosen,
                'jabatan_akademik_sebelumnya' => $request->jabatan_akademik_sebelumnya,
                'jabatan_akademik_di_usulkan' => $request->jabatan_akademik_di_usulkan,
                'tanggal_proses' => $request->tanggal_proses,
                'tanggal_selesai' => $request->tanggal_selesai,
                'surat_pengantar_pimpinan_pts' => $savedFilePath,
                'berita_acara_senat' => $savedFilePathBerita,
            ]);

            return redirect()->route('dosen.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function filter(Request $request)
    {
        
    }

    public function detail(Request $request, string $id) 
    {
        
    }
}

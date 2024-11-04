<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\Validator;

class KlasifikasiController extends Controller
{
    public function index()
    {
        $title = 'Jenis Dokumen';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'jenis dokumen', 'url' => ''],
        ];
        $data = Classification::get();

        return view('pages.klasifikasi.index', compact('data','title', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:classifications,code',
            'nama' => 'required|max:30'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Classification::create([
                'name' => $request->nama,
                'code' => $request->kode,
            ]);

            return redirect()->route('pages.klasifikasi.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $klasifikasi = Classification::find($id);
        if(!$klasifikasi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        return response()->json($klasifikasi);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:classifications,code',
            'nama' => 'required|max:30'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $klasifikasi = Classification::find($id);
    
            $klasifikasi->code = $request->kode;
            $klasifikasi->name = $request->nama;
            $klasifikasi->save();
    
            return redirect()->route('klasifikasi.index')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detail(Request $request,string $id)
    {
        $klasifikasi = Classification::findOrFail($id);
        return response()->json($klasifikasi);
    }
}

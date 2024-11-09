<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use Illuminate\Support\Facades\Validator;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Divisi';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'divisi', 'url' => ''],
        ];
        $data = Division::get();
        
        return view('pages.divisi.index', compact('data','title', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        // \dd($request);
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:divisions,kode',
            'nama' => 'required|max:30'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Division::create([
                'nama' => $request->nama,
                'kode' => $request->kode,
            ]);

            return redirect()->route('divisi.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $divisi = Division::find($id);
        if(!$divisi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        return response()->json($divisi);
    }

    public function update(Request $request, string $id)
    {
        // \dd($request);
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:divisions,kode,' . $id,
            'nama' => 'required|max:30'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $divisi = Division::findOrFail($id);
            $divisi->update([
                'kode' =>$request->kode,
                'nama' =>$request->nama,
                
            ]);

            return redirect()->route('divisi.index')->with('success', 'Data berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detail(Request $request, string $id)
    {
        $divisi = Division::findOrFail($id);
        return response()->json($divisi);
    }

    public function destroy(string $id)
    {
        try {
            $divisi = Division::find($id);
            $divisi->delete();
            return redirect()->route('divisi.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

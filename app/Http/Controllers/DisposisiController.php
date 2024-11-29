<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\Validator;

class DisposisiController extends Controller
{
    public function index()
    {

        $disposisi = Disposisi::with('letter')->get();
        $klasifikasi = Classification::all();
        $divisi = Divisi::all();

        $data = [
            'title' => 'Disposisi',
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'Disposisi', 'url' => ''],
            ],
            'disposisi'=> $disposisi,
            'klasifikasi' => $klasifikasi,
            'divisi' => $divisi,
        ];
        return view('pages.disposisi.index', $data);
    }

    public function updateStatus(Request $request, $id)
    {
        $disposition = Disposisi::findOrFail($id);

        $request->validate([
            'status' => 'required|in:dikirim,diterima,dibaca',
        ]);

        $disposition->status = $request->status;
        $disposition->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
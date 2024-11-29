<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class DisposisiController extends Controller
{
    public function index()
    {

        $disposisi = Disposisi::with('letter', 'divisi')->get();
        $klasifikasi = Classification::all();

        $data = [
            'title' => 'Disposisi',
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'Disposisi', 'url' => ''],
            ],
            'disposisi'=> $disposisi,
            'klasifikasi' => $klasifikasi,
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

    public function generatePDF($id)
    {
        $disposisi = Disposisi::with('letter', 'divisi')->findOrFail($id);

        // Load the view and pass data to it
        $pdf = PDF::loadView('pages.disposisi.pdf', ['letter' => $disposisi->letter, 'divisi' => $disposisi->divisi, 'disposisi' => $disposisi])->setPaper('a4');

        // Download PDF
        return $pdf->download('lembar_disposisi_' . $disposisi->letter->nomor_surat . '.pdf');
    }
}
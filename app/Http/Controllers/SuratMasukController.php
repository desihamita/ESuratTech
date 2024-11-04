<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\Classification;
use App\Models\Disposisi;
use Illuminate\Support\Facades\Validator;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Surat Masuk ';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Surat Masuk', 'url' => ''],
        ];
        
        $data = Letter::get();
        $classifications = Classification::all();

        return view('pages.suratmasuk.index', compact('data', 'title', 'breadcrumbs', 'classifications'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'no_agenda' => 'required|string|max:255',
            'tgl_diterima' => 'required|date',
            'perihal' => 'required|string',
            'file_surat' => 'required|file|mimes:pdf|max:2048',
            'kode_klasifikasi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $savedFilePath = null;
            if ($request->hasFile('file_surat')) {
                $savedFilePath = $request->file('file_surat')->store('uploads/surat_masuk', 'public'); 
            }

            Letter::create([
                'nomor_surat' => $request->nomor,
                'no_agenda' => $request->no_agenda,
                'pengirim' => $request->pengirim,
                'tgl_surat' => $request->tgl_surat,
                'tgl_diterima' => $request->tgl_diterima,
                'perihal' => $request->perihal,
                'file_surat' => $savedFilePath,
                'kode_klasifikasi' => $request->kode_klasifikasi, 
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('suratmasuk.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detail(Request $request, string $id) 
    {
        $surat = Letter::with(['classification', 'user'])->findOrFail($id);
        return response()->json($surat);
    }

        public function storeDisposisi(Request $request)
        {
            $request->validate([
                'penerima' => 'required|string|max:255',
                'catatan' => 'nullable|string',
                'status' => 'required|string',
            ]);

            try {
                Disposisi::create([
                    'letter_id' => $request->letter_id,
                    'penerima' => $request->penerima,
                    'catatan' => $request->catatan,
                    'status' => $request->status,
                ]);

                return redirect()->route('suratmasuk.index')->with('success', 'Data berhasil disimpan!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}

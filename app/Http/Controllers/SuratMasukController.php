<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\Classification;
use App\Models\Disposisi;
use App\Models\Division;
use Illuminate\Support\Facades\Validator;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letter = Letter::with('dispositions')->orderBy('created_at', 'desc')->get();
        $title = 'Surat Masuk ';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Surat Masuk', 'url' => ''],
        ];

        $data = $letter;
        $classifications = Classification::all();
        $divisi = Division::all();

        return view('pages.suratmasuk.index', compact('data', 'title', 'breadcrumbs', 'classifications', 'divisi'));
    }

    public function store(Request $request)
    {
        // \dd($request);
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'no_agenda' => 'required|string|max:255',
            'tgl_diterima' => 'required|date',
            'perihal' => 'required|string',
            'file_surat' => 'required|file|mimes:pdf|max:2048',
            'kode_klasifikasi' => 'required|string',
        ]);
        // \dd($validator);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');

                $originalNameWithoutExtension = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = date('Y_m_d') . '_' . $originalNameWithoutExtension . '.' . $extension;
                $file->move(public_path('uploads/surat_masuk'), $newFileName);
            }

            Letter::create([
                'nomor_surat' => $request->nomor_surat,
                'no_agenda' => $request->no_agenda,
                'pengirim' => $request->pengirim,
                'tgl_surat' => $request->tgl_surat,
                'tgl_diterima' => $request->tgl_diterima,
                'perihal' => $request->perihal,
                'file_surat' => $newFileName,
                'kode_klasifikasi' => $request->kode_klasifikasi,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('suratmasuk.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // \dd($request);
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'no_agenda' => 'required|string|max:255',
            'tgl_diterima' => 'required|date',
            'perihal' => 'required|string',
            'kode_klasifikasi' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        // \dd($validator);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $letter = Letter::findOrFail($id);

            // Cek apakah ada file baru yang diunggah
            if ($request->hasFile('file_surat')) {
                // Hapus file lama jika ada
                if ($letter->file_surat && file_exists(public_path('uploads/surat_masuk/' . $letter->file_surat))) {
                    unlink(public_path('uploads/surat_masuk/' . $letter->file_surat));
                }

                // Simpan file baru
                $file = $request->file('file_surat');
                $originalNameWithoutExtension = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = date('Y_m_d') . '_' . $originalNameWithoutExtension . '.' . $extension;
                $file->move(public_path('uploads/surat_masuk'), $newFileName);

                // Set nama file baru ke variabel
                $letter->file_surat = $newFileName;
            }
            $letter->update([
                'tgl_surat' => $request->tgl_surat,
                'nomor_surat' => $request->nomor_surat,
                'no_agenda' => $request->no_agenda,
                'pengirim' => $request->pengirim,
                'penerima' => $request->penerima,
                'perihal' => $request->perihal,
                'devisi' => $request->devisi,
                'kode_klasifikasi' => $request->kode_klasifikasi,
                'file_surat' => $letter->file_surat,
            ]);

            return redirect()->route('suratmasuk.index')->with('success', 'Data berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeDisposisi(Request $request)
    {
        $request->validate([
            'letter_id' => 'required|exists:letters,id',
            'penerima' => 'required|string|exists:divisions,id',
            'catatan' => 'nullable|string',
            'status' => 'required||in:dikirim,diterima,dibaca',
            'priority' => 'nullable|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);
        
        
        try {
            $disposisi = Disposisi::where('letter_id', $request->letter_id)->first();
            Disposisi::create([
                'letter_id' => $request->letter_id,
                'penerima' => $request->penerima,
                'catatan' => $request->catatan,
                'status' => $request->status,
                'status' => $request->status,   
                'status' => $request->status,
            ]);

            return redirect()->route('suratmasuk.index')->with('success',  'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

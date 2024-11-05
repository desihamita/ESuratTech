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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $letter = Letter::findOrFail($id);

        if ($letter->file_surat && file_exists(public_path('uploads/surat_masuk/' . $letter->file_surat))) {
            unlink(public_path('uploads/surat_masuk/' . $letter->file_surat));
        }

        // Hapus data surat masuk dari database
        $letter->delete();
        return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}

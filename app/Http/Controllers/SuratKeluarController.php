<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\LetterOut;
use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\Validator;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Dapatkan tgl_surat dari input form
        $tglSurat = $request->input('tgl_surat', now()->toDateString());

        // Ambil bulan dan tahun dari tgl_surat
        $currentMonth = \Carbon\Carbon::parse($tglSurat)->format('m');
        $currentYear = \Carbon\Carbon::parse($tglSurat)->format('Y');

        // cari surt terkahir
        $lastSurat = LetterOut::whereRaw('MONTH(tgl_surat) = ?', [$currentMonth])
            ->whereRaw('YEAR(tgl_surat) = ?', [$currentYear])
            ->orderBy('id', 'desc')
            ->first();

        // Tentukan nomor surat baru 
        $newNumber = $lastSurat ? intval(substr($lastSurat->nomor_surat, 0, 3)) + 1 : 1;

        // Konversi bulan ke angka Romawi
        $romawi = [
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII',
        ];
        $month = $romawi[$currentMonth];

        // Format nomor surat
        $nomorSurat = sprintf('%03d/SE/BU/NIIT/%s/%s', $newNumber, $month, $currentYear);




        $letterOut = LetterOut::with('devisi', 'classification')->OrderBy('nomor_surat','desc')->get();
        $devisi = Division::all();
        $klasifikasi = Classification::all();
        $today = now()->toDateString();
        $data = [
            'title'=> 'Surat Keluar ',
            'breadcrumbs' => [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Surat Keluar', 'url' => ''],
            ],
            'letterOut' => $letterOut,
            'divisi' => $devisi,
            'klasifikasi' => $klasifikasi,
            'nomorSurat'=> $nomorSurat,
            'today'=>$today
            ];
        // dd($letterOut);
        return view('pages.suratkeluar.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // \dd($request);
        $validator = Validator::make($request->all(), [
            'tgl_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'no_agenda' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'perihal' => 'required|string',
            'devisi' => 'required',
            'kode_klasifikasi' => 'required|string',
            'file_surat' => 'required|file|mimes:pdf|max:2048',
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
                $newFileName = date('Y_m_d') . '_'. $originalNameWithoutExtension .'.' . $extension;
                $file->move(public_path('uploads/surat_keluar'), $newFileName);
            }

            LetterOut::create([
                'tgl_surat' => $request->tgl_surat,
                'nomor_surat' => $request->nomor_surat,
                'no_agenda' => $request->no_agenda,
                'pengirim' => $request->pengirim,
                'penerima' => $request->penerima,
                'perihal' => $request->perihal,
                'devisi' => $request->devisi,
                'kode_klasifikasi' => $request->kode_klasifikasi,
                'file_surat' => $newFileName,
            ]);

            return redirect()->route('suratkeluar.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tgl_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'no_agenda' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'perihal' => 'required|string',
            'devisi' => 'required',
            'kode_klasifikasi' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $letterOut = LetterOut::findOrFail($id);

            // Cek apakah ada file baru yang diunggah
            if ($request->hasFile('file_surat')) {
                // Hapus file lama jika ada
                if ($letterOut->file_surat && file_exists(public_path('uploads/surat_keluar/' . $letterOut->file_surat))) {
                    unlink(public_path('uploads/surat_keluar/' . $letterOut->file_surat));
                }

                // Simpan file baru
                $file = $request->file('file_surat');
                $originalNameWithoutExtension = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = date('Y_m_d') . '_' . $originalNameWithoutExtension . '.' . $extension;
                $file->move(public_path('uploads/surat_keluar'), $newFileName);

                // Set nama file baru ke variabel
                $letterOut->file_surat = $newFileName;
            }
            $letterOut->update([
                'tgl_surat' => $request->tgl_surat,
                'nomor_surat' => $request->nomor_surat,
                'no_agenda' => $request->no_agenda,
                'pengirim' => $request->pengirim,
                'penerima' => $request->penerima,
                'perihal' => $request->perihal,
                'devisi' => $request->devisi,
                'kode_klasifikasi' => $request->kode_klasifikasi,
                'file_surat' => $letterOut->file_surat, 
            ]);

            return redirect()->route('suratkeluar.index')->with('success', 'Data berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


           


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $letterOut = LetterOut::findOrFail($id);

        if ($letterOut->file_surat && file_exists(public_path('uploads/surat_keluar/' . $letterOut->file_surat))) {
            unlink(public_path('uploads/surat_keluar/' . $letterOut->file_surat));
        }

        // Hapus data surat keluar dari database
        $letterOut->delete();
        return redirect()->route('suratkeluar.index')->with('success', 'Surat keluar berhasil dihapus.');
    }

}


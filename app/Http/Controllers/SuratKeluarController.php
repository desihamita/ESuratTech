<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\LetterOut;
use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\Validator;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {   
        $letterOut = LetterOut::with('devisi', 'classification')->orderBy('nomor_surat', 'desc')->get();
        $devisiList = Division::all();
        $klasifikasi = Classification::all();
        $today = now()->toDateString();
        
        $data = [
            'title' => 'Surat Keluar',
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'Surat Keluar', 'url' => ''],
            ],
            'letterOut' => $letterOut,
            'divisi' => $devisiList,
            'klasifikasi' => $klasifikasi,
            'today' => $today,
            'nomorSurat' => null,
        ];
        
        return view('pages.suratkeluar.index', $data);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tgl_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'no_agenda' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'perihal' => 'required|string',
            'devisi' => 'required',  // Updated to 'devisi'
            'kode_klasifikasi' => 'required|string',
            'file_surat' => 'required|file|mimes:pdf|max:2048',
        ]);

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

            $tglSurat = $request->tgl_surat;
            $nomorSurat = $request->nomor_surat;
            $noAgenda = $request->no_agenda;
            $devisi = $request->devisi;  // Updated to 'devisi'
            $kodeKlasifikasi = $request->kode_klasifikasi;

            LetterOut::create([
                'tgl_surat' => $tglSurat,
                'nomor_surat' => $nomorSurat,
                'no_agenda' => $noAgenda,
                'pengirim' => $request->pengirim,
                'penerima' => $request->penerima,
                'perihal' => $request->perihal,
                'devisi' => $devisi,  // Updated to 'devisi'
                'kode_klasifikasi' => $kodeKlasifikasi,
                'file_surat' => $newFileName,
            ]);

            return redirect()->route('suratkeluar.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

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

            $tglSurat = $request->tgl_surat;
            $nomorSurat = $request->nomor_surat;
            $noAgenda = $request->no_agenda;
            $devisi = $request->devisi;
            $kodeKlasifikasi = $request->kode_klasifikasi;

            // Generate the nomor_surat
            $currentMonth = \Carbon\Carbon::parse($tglSurat)->format('m');
            $currentYear = \Carbon\Carbon::parse($tglSurat)->format('Y');

            // Convert month to Roman numeral
            $romawi = [
                '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
                '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
                '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII',
            ];
            $month = $romawi[$currentMonth];

            // Generate the nomor_surat
            $nomorSuratGenerated = sprintf('%s/%s/%s/NIIT/%s/%s', $noAgenda, $kodeKlasifikasi, $devisi, $month, $currentYear);

            // Update the record
            $letterOut->update([
                'tgl_surat' => $tglSurat,
                'nomor_surat' => $nomorSuratGenerated,  // Use the generated nomor_surat
                'no_agenda' => $noAgenda,
                'pengirim' => $request->pengirim,
                'penerima' => $request->penerima,
                'perihal' => $request->perihal,
                'devisi' => $devisi,
                'kode_klasifikasi' => $kodeKlasifikasi,
                'file_surat' => $letterOut->file_surat,
            ]);

            return redirect()->route('suratkeluar.index')->with('success', 'Data berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generateNomorSurat(Request $request)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:10',
            'devisi' => 'required|string|max:10',  // Updated to 'devisi'
            'tgl_surat' => 'required|date',
            'no_agenda' => 'required|regex:/^[1-9]{1}[0-9]{0,2}[a-zA-Z]*$/',
        ]);

        $tglSurat = $request->input('tgl_surat');
        $kodeKlasifikasi = $request->input('kode_klasifikasi');
        $devisi = $request->input('devisi');  // Updated to 'devisi'
        $noAgenda = $request->input('no_agenda');

        // Cek apakah no_agenda lebih dari 399
        $noAgendaNumber = intval($noAgenda);  // Ambil angka dari no_agenda
        if ($noAgendaNumber > 399) {
            return response()->json(['error' => 'No agenda tidak boleh lebih dari 399'], 400);
        }

        // Ambil bulan dan tahun dari tgl_surat
        $currentMonth = \Carbon\Carbon::parse($tglSurat)->format('m');
        $currentYear = \Carbon\Carbon::parse($tglSurat)->format('Y');

        // Cari surat terakhir berdasarkan bulan dan tahun
        $lastSurat = LetterOut::whereRaw('MONTH(tgl_surat) = ?', [$currentMonth])
            ->whereRaw('YEAR(tgl_surat) = ?', [$currentYear])
            ->orderBy('id', 'desc')
            ->first();

        // Konversi bulan ke angka Romawi
        $romawi = [
            '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
            '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
            '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII',
        ];
        $month = $romawi[$currentMonth];

        // Format nomor surat
        $nomorSurat = sprintf('%s/%s/%s/NIIT/%s/%s', $noAgenda, $kodeKlasifikasi, $devisi, $month, $currentYear);

        return response()->json(['nomor_surat' => $nomorSurat]);
    }
}


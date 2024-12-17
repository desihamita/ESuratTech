<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\LetterOut;
use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\Lembaga;
use App\Models\CircularLetter;
use App\Models\SuratTugas;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {   
        $letterOut = LetterOut::with('divisi', 'klasifikasi')->orderBy('nomor_surat', 'desc')->get();
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
            'devisi' => 'required',
            'kode_klasifikasi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Persiapkan data untuk surat keluar
            $letterData = [
                'tgl_surat' => $request->tgl_surat,
                'nomor_surat' => $request->nomor_surat,
                'no_agenda' => $request->no_agenda,
                'pengirim' => $request->pengirim,
                'penerima' => $request->penerima,
                'perihal' => $request->perihal,
                'devisi' => $request->devisi,
                'kode_klasifikasi' => $request->kode_klasifikasi,
            ];
            $letterOut = LetterOut::create($letterData);

            // Jika jenis dokumen adalah Surat Tugas
            if ($request->kode_klasifikasi == 'ST') {
                $letterData['nama'] = $request->namaDitugaskan;
                $letterData['jabatan'] = $request->jabatan;
                $letterData['tgl_acara'] = $request->tgl_acara;
                $letterData['waktu'] = $request->waktu;
                $letterData['tempat'] = $request->tempat;
                $letterData['letterout_id'] = $letterOut->id;

                SuratTugas::create($letterData);
            }
            // Jika jenis dokumen adalah Surat Edaran
            elseif ($request->kode_klasifikasi == 'SE') {
                $letterData['konten'] = $request->konten;
                $letterData['letterout_id'] = $letterOut->id;

                CircularLetter::create($letterData);
            }

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
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            $letterOut = LetterOut::findOrFail($id);
            $suratTugas = SuratTugas::where('letterout_id', $id)->first();

            // Update data Surat Keluar
            $tglSurat = $request->tgl_surat;
            $noAgenda = $request->no_agenda;
            $kodeKlasifikasi = $request->kode_klasifikasi;
            $devisi = $request->devisi;
    
            $currentMonth = \Carbon\Carbon::parse($tglSurat)->format('m');
            $currentYear = \Carbon\Carbon::parse($tglSurat)->format('Y');
    
            $romawi = [
                '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
                '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
                '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII',
            ];
            $month = $romawi[$currentMonth];
    
            $nomorSuratGenerated = sprintf('%s/%s/%s/NIIT/%s/%s', $noAgenda, $kodeKlasifikasi, $devisi, $month, $currentYear);
    
            $letterOut->update([
                'tgl_surat' => $tglSurat,
                'nomor_surat' => $nomorSuratGenerated,
                'no_agenda' => $noAgenda,
                'pengirim' => $request->pengirim,
                'penerima' => $request->penerima,
                'perihal' => $request->perihal,
                'devisi' => $devisi,
                'kode_klasifikasi' => $kodeKlasifikasi,
            ]);
    
            // Update data jenis dokumen khusus
            if ($kodeKlasifikasi === 'ST') {
                $suratTugas = SuratTugas::firstOrNew(['letterout_id' => $letterOut->id]);
                $suratTugas->fill([
                    'nama' => $request->namaDitugaskan,
                    'jabatan' => $request->jabatan,
                    'tgl_acara' => $request->tgl_acara,
                    'waktu' => $request->waktu,
                    'tempat' => $request->tempat,
                ])->save();
            } elseif ($kodeKlasifikasi === 'SE') {
                $suratEdaran = SuratEdaran::firstOrNew(['letterout_id' => $letterOut->id]);
                $suratEdaran->fill([
                    'nomor_edaran' => $request->nomor_edaran,
                    'tgl_edaran' => $request->tgl_edaran,
                ])->save();
            }
    
            return redirect()->route('suratkeluar.index')->with('success', 'Data berhasil diubah!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generateNomorSurat(Request $request)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:10',
            'devisi' => 'required|string|max:10', 
            'tgl_surat' => 'required|date',
            'no_agenda' => 'required|regex:/^[1-9]{1}[0-9]{0,2}[a-zA-Z]*$/',
        ]);

        $tglSurat = $request->input('tgl_surat');
        $kodeKlasifikasi = $request->input('kode_klasifikasi');
        $devisi = $request->input('devisi'); 
        $noAgenda = $request->input('no_agenda');

        $noAgendaNumber = intval($noAgenda);  
        if ($noAgendaNumber > 399) {
            return response()->json(['error' => 'No agenda tidak boleh lebih dari 399'], 400);
        }

        $currentMonth = \Carbon\Carbon::parse($tglSurat)->format('m');
        $currentYear = \Carbon\Carbon::parse($tglSurat)->format('Y');

        $lastSurat = LetterOut::whereRaw('MONTH(tgl_surat) = ?', [$currentMonth])
            ->whereRaw('YEAR(tgl_surat) = ?', [$currentYear])
            ->orderBy('id', 'desc')
            ->first();

        $romawi = [
            '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
            '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
            '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII',
        ];
        $month = $romawi[$currentMonth];

        $nomorSurat = sprintf('%s/%s/%s/NIIT/%s/%s', $noAgenda, $kodeKlasifikasi, $devisi, $month, $currentYear);

        return response()->json(['nomor_surat' => $nomorSurat]);
    }

    public function cetak($id)
    {
        // Ambil surat keluar berdasarkan ID
        $suratKeluar = LetterOut::with('klasifikasi','suratTugas')->findOrFail($id);

        // Ambil data lembaga secara manual
        $lembaga = Lembaga::first(); // Jika hanya ada satu lembaga

        if (!$lembaga) {
            abort(404, 'Data lembaga tidak ditemukan.');
        }

        // Pilih template berdasarkan kode klasifikasi
        $kodeKlasifikasi = $suratKeluar->kode_klasifikasi;
        $template = match ($kodeKlasifikasi) {
            'SE' => 'pages.suratKeluar.pdf.se',
            'ST' => 'pages.suratKeluar.pdf.st',
            default => 'pages.suratKeluar.pdf.default',
        };

        // Generate PDF
        $pdf = PDF::loadView($template, [
            'suratKeluar' => $suratKeluar,
            'lembaga' => $lembaga,
            'klasifikasi' => $suratKeluar->klasifikasi,
            'suratTugas' => $suratKeluar->suratTugas,
        ])->setPaper('a4');

        // Bersihkan nomor surat
        $cleaned_nomor_surat = preg_replace('/[\/\\\\]/', '', $suratKeluar->nomor_surat);

        return $pdf->download('Surat_' . $kodeKlasifikasi . '_' . $cleaned_nomor_surat . '.pdf');
    }
}


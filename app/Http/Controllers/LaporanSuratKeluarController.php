<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterOut;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanSuratKeluarController extends Controller
{
    public function index()
    {
        $letter = LetterOut::get();
        $title = 'Laporan Surat Keluar ';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Laporan Surat Keluar', 'url' => ''],
        ];
        $data = $letter;

        return view('pages.laporan.surat-keluar.index', compact('data', 'title', 'breadcrumbs'));
    }

    public function filter(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = LetterOut::whereBetween('tgl_surat', [$startDate, $endDate])->get();
        return response()->json(['data' => $data]);
    }

    public function exportPdf(Request $request)
    {
        $query = LetterOut::query();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $query->whereBetween('tgl_surat', [$start_date, $end_date]);
        }
        
        $data = $query->get();

        $start_date = Carbon::parse($request->start_date)->format('F Y');
        $end_date = Carbon::parse($request->end_date)->format('F Y');

        $pdf = Pdf::loadView('pages.laporan.surat-keluar.pdf', compact('data', 'start_date', 'end_date'))->setPaper('a4');
        return $pdf->download('laporan_surat_keluar.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = LetterOut::query();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $query->whereBetween('tgl_surat', [$start_date, $end_date]);
        }

        $data = $query->get();

        return Excel::download(new \App\Exports\SuratKeluarExport($data, $start_date, $end_date), 'laporan_surat_keluar.xlsx');
    }
}

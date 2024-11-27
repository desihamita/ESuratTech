<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\Classification;
use App\Models\Disposisi;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class LaporanSuratMasukController extends Controller
{
    public function index()
    {
        $letter = Letter::with('dispositions')->orderBy('created_at', 'desc')->get();
        $title = 'Laporan Surat Masuk ';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Laporan Surat Masuk', 'url' => ''],
        ];

        $data = $letter;
        $classifications = Classification::all();

        return view('pages.laporan.surat-masuk.index', compact('data', 'title', 'breadcrumbs', 'classifications'));
    }

    public function filter(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = Letter::whereBetween('tgl_surat', [$startDate, $endDate])->get();
        return response()->json(['data' => $data]);
    }

    public function exportPdf(Request $request)
    {
        $query = Letter::query();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $query->whereBetween('tgl_surat', [$start_date, $end_date]);
        }
        
        $data = $query->get();

        $start_date = Carbon::parse($request->start_date)->format('F Y');
        $end_date = Carbon::parse($request->end_date)->format('F Y');

        $pdf = Pdf::loadView('pages.laporan.surat-masuk.pdf', compact('data', 'start_date', 'end_date'))->setPaper('a4');
        return $pdf->download('laporan_surat_masuk.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Letter::query();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $query->whereBetween('tgl_surat', [$start_date, $end_date]);
        }

        $data = $query->get();

        return Excel::download(new \App\Exports\SuratMasukExport($data, $start_date, $end_date), 'laporan_surat_masuk.xlsx');
    }
}

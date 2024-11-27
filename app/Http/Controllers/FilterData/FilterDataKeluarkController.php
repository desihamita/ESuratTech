<?php

namespace App\Http\Controllers\FilterData;

use App\Http\Controllers\Controller;
use App\Models\LetterOut;
use Illuminate\Http\Request;

class FilterDataKeluarkController extends Controller
{
    public function filterSuratkeluar(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = LetterOut::whereBetween('tgl_surat', [$request->start_date, $request->end_date])->get();

        $html = '';
        foreach ($data as $index => $d) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . $d->tgl_surat . '</td>';
            $html .= '<td>' . $d->nomor_surat . '</td>';
            $html .= '<td>' . $d->no_agenda . '</td>';
            $html .= '<td>' . $d->kode_klasifikasi . '</td>';
            $html .= '<td>' . $d->perihal . '</td>';
            $html .= '<td>' . $d->perihal . '</td>';
            $html .= '<td>' . $d->devisi . '</td>';
            $html .= '<td>' . $d->pengirim . '</td>';
            $html .= '<td>' . $d->penerima . '</td>';
            $html .= '<td>';
            if (!empty($d->file_surat)) {
                $html .= '<a href="' . asset('uploads/surat_keluar/' . $d->file_surat) . '" target="_blank">Unduh Surat</a>';
            } else {
                $html .= '<p>Tidak ada file surat.</p>';
            }
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-sm btn-primary edit-btn" data-toggle="modal" data-target="#modal-edit' . $d->id . '">
            <i class="fas fa-edit"></i>
          </button>';
            $html .= '<button class="btn btn-sm btn-info detail-btn" data-toggle="modal" data-target="#modal-detail' . $d->id . '">
            <i class="fas fa-eye"></i>
          </button>';
            $html .= '<button class="btn btn-sm btn-success print-btn" data-id="' . $d->id . '" data-toggle="modal" data-target="#modal-print">
            <i class="fas fa-solid fa-print"></i>
          </button>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        return response()->json(['html' => $html]);
    }
}

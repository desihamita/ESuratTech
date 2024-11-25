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

        $data = LetterOut::whereBetween('tgl_diterima', [$request->start_date, $request->end_date])->get();

        $html = '';
        foreach ($data as $index => $d) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . $d->nomor_surat . '</td>';
            $html .= '<td>' . $d->no_agenda . '</td>';
            $html .= '<td>' . $d->tgl_diterima . '</td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning" data-id="" data-toggle="modal" data-target="#modal-disposisi' . $d->id . '">
                    <i class="fas fa-clipboard"></i>
                  </button>';
            if ($d->dispositions && $d->dispositions->isNotEmpty()) {
                foreach ($d->dispositions as $ds) {
                    $statusClass = $ds->status === 'dikirim' ? 'badge-warning' : ($ds->status === 'diterima' ? 'badge-primary' : ($ds->status === 'dibaca' ? 'badge-success' : ''));
                    $html .= '<small class="badge ' . $statusClass . '">' . $ds->status . '</small>';
                }
            } else {
                $html .= '<small class="text-sm badge badge-secondary">Belum Ada Aksi</small>';
            }
            $html .= '</td>';
            $html .= '<td>' . $d->pengirim . '</td>';
            $html .= '<td>' . $d->perihal . '</td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-sm btn-primary edit-btn" data-id="" data-toggle="modal" data-target="#modal-edit' . $d->id . '">
                    <i class="fas fa-edit"></i>
                  </button>';
            $html .= '<button class="btn btn-sm btn-info detail-btn" data-id="" data-toggle="modal" data-target="#modal-detail' . $d->id . '">
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

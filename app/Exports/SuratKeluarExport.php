<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;

class SuratKeluarExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents, ShouldAutoSize
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = \Carbon\Carbon::parse($startDate)->format('d F Y');
        $this->endDate = \Carbon\Carbon::parse($endDate)->format('d F Y');
    }

    public function collection()
    {
        return $this->data->map(function($item, $index) {
            return [
                'No' => $index + 1,
                'Tanggal' => \Carbon\Carbon::parse($item->tgl_surat)->format('d F Y'),
                'No Surat' => $item->nomor_surat,
                'No Agenda' => $item->no_agenda,
                'Jenis Document' => $item->kode_klasifikasi,
                'Divisi' => $item->devisi,
                'Perihal' => $item->perihal,
                'Pengirim' => $item->pengirim,
                'Penerima' => $item->penerima,
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['Laporan Data Surat Keluar'],
            ['Periode : ' . $this->startDate . ' - ' . $this->endDate],
            [],
            ['No', 'Tanggal', 'No Surat', 'No Agenda', 'Jenis Document', 'Divisi', 'Perihal', 'Pengirim', 'Penerima'],
        ];
    }

    public function title(): string
    {
        return 'Laporan Data Surat Keluar';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style for the report title
            'A1' => ['font' => ['bold' => true, 'size' => 20]],
            'A2' => ['font' => ['italic' => true, 'size' => 12]],
            // Align title and period to the center
            'A1:I1' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'A2:I2' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
            // Style for table header
            'A4:I4' => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF2CC']],
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
            // Set borders for data rows
            'A5:I' . ($this->data->count() + 4) => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function($event) {
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                foreach (range('A', 'I') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}

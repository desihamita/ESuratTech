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

class SuratMasukExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents, ShouldAutoSize
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = \Carbon\Carbon::parse($startDate)->format('F Y');
        $this->endDate = \Carbon\Carbon::parse($endDate)->format('F Y');
    }

    public function collection()
    {
        return $this->data->map(function($item, $index) {
            return [
                'No' => $index + 1,
                'Nomor Surat' => $item->nomor_surat,
                'Agenda' => $item->no_agenda,
                'Tgl Surat' => \Carbon\Carbon::parse($item->tgl_diterima)->format('d F Y'),
                'Pengirim' => $item->pengirim,
                'Perihal' => $item->perihal,
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['Laporan Data Surat Masuk'],
            ['Periode : ' . $this->startDate . ' - ' . $this->endDate],
            [],
            ['No', 'Nomor Surat', 'Agenda', 'Tgl Surat', 'Pengirim', 'Perihal'],
        ];
    }

    public function title(): string
    {
        return 'Laporan Data Surat Masuk';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style for the report title
            'A1' => ['font' => ['bold' => true, 'size' => 20]],
            'A2' => ['font' => ['italic' => true, 'size' => 12]],
            // Align title and period to the center
            'A1:F1' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'A2:F2' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
            // Style for table header
            'A4:F4' => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF2CC']],
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
            // Set borders for data rows
            'A5:F' . ($this->data->count() + 4) => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function($event) {
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->mergeCells('A2:F2');
                foreach (range('A', 'F') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}

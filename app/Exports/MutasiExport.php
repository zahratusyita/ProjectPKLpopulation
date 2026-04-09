<?php

namespace App\Exports;

use App\Support\MutasiSchema;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MutasiExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private readonly Collection $rows,
        private readonly string $jenis,
        private readonly string $tahun
    ) {
    }

    public function collection(): Collection
    {
        return $this->rows;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return array_values(MutasiSchema::exportLabels($this->jenis));
    }

    public function map($row): array
    {
        return array_values(MutasiSchema::exportRow($row, $this->jenis));
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            3 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '1E3A5F'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastColumn = Coordinate::stringFromColumnIndex(count($this->headings()));
                $lastRow = max(3, $this->rows->count() + 3);

                $event->sheet->mergeCells('A1:'.$lastColumn.'1');
                $event->sheet->mergeCells('A2:'.$lastColumn.'2');
                $event->sheet->setCellValue('A1', 'Data Mutasi '.ucfirst($this->jenis).' Ternak');
                $event->sheet->setCellValue('A2', 'Tahun data: '.$this->tahun.' | Diekspor: '.now()->format('d-m-Y H:i'));

                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E3A5F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true, 'color' => ['rgb' => '475569']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->setAutoFilter('A3:'.$lastColumn.'3');
                $event->sheet->freezePane('A4');
                $event->sheet->getStyle('A3:'.$lastColumn.$lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'CBD5E1'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}

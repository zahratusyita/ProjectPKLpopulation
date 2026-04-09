<?php

namespace App\Exports;

use App\Support\MutasiSchema;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MutasiTemplateExport implements FromArray, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithStyles
{
    public function __construct(
        private readonly string $jenis
    ) {
    }

    public function array(): array
    {
        return [];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return array_values(MutasiSchema::templateLabels($this->jenis));
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

                $event->sheet->mergeCells('A1:'.$lastColumn.'1');
                $event->sheet->mergeCells('A2:'.$lastColumn.'2');
                $event->sheet->setCellValue('A1', 'Template Import Mutasi '.ucfirst($this->jenis).' Ternak');
                $event->sheet->setCellValue('A2', 'Isi kolom tanggal dengan format YYYY-MM-DD dan pastikan NIK peternak sudah terdaftar di sistem.');
                $event->sheet->setAutoFilter('A3:'.$lastColumn.'3');
                $event->sheet->freezePane('A4');
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E3A5F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true, 'color' => ['rgb' => '475569']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $event->sheet->getStyle('A3:'.$lastColumn.'4')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'CBD5E1'],
                        ],
                    ],
                ]);
            },
        ];
    }
}

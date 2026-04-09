<?php

namespace App\Imports;

use App\Services\TernakMutationService;
use App\Support\MutasiSchema;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class MutasiTernaksImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    private Collection $peternaks;
    private TernakMutationService $ternakMutationService;

    public function __construct(
        private readonly string $jenis,
        Collection $peternaks,
        private readonly ?int $tahunData = null
    ) {
        $this->peternaks = $peternaks->keyBy(fn ($peternak) => trim((string) $peternak->nik));
        $this->ternakMutationService = new TernakMutationService();
    }

    public function collection(Collection $rows): void
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows->values() as $index => $row) {
                $rowData = $row instanceof Collection ? $row->toArray() : (array) $row;
                $rowNumber = $this->headingRow() + $index + 1;
                $nik = trim((string) ($rowData['nik'] ?? ''));

                if ($nik === '') {
                    throw new \RuntimeException('Baris '.$rowNumber.': kolom NIK wajib diisi.');
                }

                $peternak = $this->peternaks->get($nik);

                if (! $peternak) {
                    throw new \RuntimeException('Baris '.$rowNumber.': NIK '.$nik.' tidak ditemukan atau tidak termasuk wilayah Anda.');
                }

                $tanggal = $this->parseDate($rowData['tanggal'] ?? null, $rowNumber);

                if ($this->tahunData !== null && (int) $tanggal->format('Y') !== $this->tahunData) {
                    throw new \RuntimeException('Baris '.$rowNumber.': tahun pada kolom tanggal harus sama dengan tahun data aktif ('.$this->tahunData.').');
                }

                $animalData = $this->buildAnimalData($rowData, $rowNumber);

                if (MutasiSchema::totalAnimalCount($animalData) === 0) {
                    throw new \RuntimeException('Baris '.$rowNumber.': minimal isi satu jumlah ternak.');
                }

                $this->ternakMutationService->upsert($this->jenis, [
                    'jenis_mutasi' => $this->jenis,
                    'tanggal' => $tanggal->format('Y-m-d'),
                    'peternak_id' => $peternak->id,
                ], array_merge($animalData, [
                    'tahun' => (int) $tanggal->format('Y'),
                    'keterangan' => $this->normalizeString($rowData['keterangan'] ?? null),
                ]));
            }
        });
    }

    public function headingRow(): int
    {
        return 3;
    }

    private function buildAnimalData(array $row, int $rowNumber): array
    {
        $normalized = [];

        foreach (array_keys(MutasiSchema::inputLabels($this->jenis)) as $field) {
            $value = $row[$field] ?? null;

            if ($value === null || $value === '') {
                $normalized[$field] = 0;
                continue;
            }

            if (! is_numeric($value)) {
                throw new \RuntimeException('Baris '.$rowNumber.': kolom '.$field.' harus berupa angka.');
            }

            if ((float) $value < 0) {
                throw new \RuntimeException('Baris '.$rowNumber.': kolom '.$field.' tidak boleh bernilai negatif.');
            }

            $normalized[$field] = (int) $value;
        }

        return MutasiSchema::fillAnimalData($this->jenis, $normalized);
    }

    private function parseDate(mixed $value, int $rowNumber): Carbon
    {
        if ($value === null || $value === '') {
            throw new \RuntimeException('Baris '.$rowNumber.': kolom tanggal wajib diisi.');
        }

        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value));
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable) {
            throw new \RuntimeException('Baris '.$rowNumber.': format tanggal tidak valid. Gunakan YYYY-MM-DD.');
        }
    }

    private function normalizeString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}

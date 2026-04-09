<?php

namespace App\Support;

class MutasiSchema
{
    public static function isKelahiran(string $jenis): bool
    {
        return $jenis === 'kelahiran';
    }

    public static function mamalia(): array
    {
        return [
            'sapi' => 'Sapi',
            'kerbau' => 'Kerbau',
            'kuda' => 'Kuda',
            'kambing' => 'Kambing',
            'babi' => 'Babi',
            'domba' => 'Domba',
        ];
    }

    public static function unggas(): array
    {
        return [
            'ayam_ras' => 'Ayam Ras',
            'ayam_buras' => 'Ayam Buras',
            'ayam_petelur' => 'Ayam Petelur',
            'itik' => 'Itik',
            'puyuh' => 'Puyuh',
        ];
    }

    public static function animalColumns(): array
    {
        return [
            'sapi_anak_jantan',
            'sapi_anak_betina',
            'sapi_muda_jantan',
            'sapi_muda_betina',
            'sapi_dewasa_jantan',
            'sapi_dewasa_betina',
            'kerbau_anak_jantan',
            'kerbau_anak_betina',
            'kerbau_muda_jantan',
            'kerbau_muda_betina',
            'kerbau_dewasa_jantan',
            'kerbau_dewasa_betina',
            'kuda_anak_jantan',
            'kuda_anak_betina',
            'kuda_muda_jantan',
            'kuda_muda_betina',
            'kuda_dewasa_jantan',
            'kuda_dewasa_betina',
            'kambing_anak_jantan',
            'kambing_anak_betina',
            'kambing_muda_jantan',
            'kambing_muda_betina',
            'kambing_dewasa_jantan',
            'kambing_dewasa_betina',
            'babi_anak_jantan',
            'babi_anak_betina',
            'babi_muda_jantan',
            'babi_muda_betina',
            'babi_dewasa_jantan',
            'babi_dewasa_betina',
            'domba_anak_jantan',
            'domba_anak_betina',
            'domba_muda_jantan',
            'domba_muda_betina',
            'domba_dewasa_jantan',
            'domba_dewasa_betina',
            'ayam_ras',
            'ayam_buras',
            'ayam_petelur',
            'itik',
            'puyuh',
        ];
    }

    public static function inputLabels(string $jenis): array
    {
        if (self::isKelahiran($jenis)) {
            $labels = [];

            foreach (self::mamalia() as $field => $label) {
                $labels[$field.'_jantan'] = $label.' Jantan';
                $labels[$field.'_betina'] = $label.' Betina';
            }

            foreach (self::unggas() as $field => $label) {
                $labels[$field] = $label;
            }

            return $labels;
        }

        $labels = [];
        $ageMap = [
            'anak' => 'Anak',
            'muda' => 'Muda',
            'dewasa' => 'Dewasa',
        ];

        foreach (self::mamalia() as $field => $label) {
            foreach ($ageMap as $ageKey => $ageLabel) {
                $labels[$field.'_'.$ageKey.'_jantan'] = $label.' '.$ageLabel.' Jantan';
                $labels[$field.'_'.$ageKey.'_betina'] = $label.' '.$ageLabel.' Betina';
            }
        }

        foreach (self::unggas() as $field => $label) {
            $labels[$field] = $label;
        }

        return $labels;
    }

    public static function exportLabels(string $jenis): array
    {
        return [
            'tanggal' => 'Tanggal',
            'nik' => 'NIK',
            'nama' => 'Nama Peternak',
            'kabupaten' => 'Kabupaten/Kota',
            'kecamatan' => 'Kecamatan',
            'desa_kelurahan' => 'Desa/Kelurahan',
        ] + self::inputLabels($jenis) + [
            'keterangan' => 'Keterangan',
        ];
    }

    public static function templateLabels(string $jenis): array
    {
        return [
            'tanggal' => 'Tanggal',
            'nik' => 'NIK',
            'nama' => 'Nama Peternak (opsional)',
        ] + self::inputLabels($jenis) + [
            'keterangan' => 'Keterangan',
        ];
    }

    public static function fillAnimalData(string $jenis, array $input): array
    {
        $data = [];

        foreach (self::animalColumns() as $column) {
            $data[$column] = 0;
        }

        if (self::isKelahiran($jenis)) {
            foreach (array_keys(self::mamalia()) as $field) {
                $data[$field.'_anak_jantan'] = self::toInt($input[$field.'_jantan'] ?? 0);
                $data[$field.'_anak_betina'] = self::toInt($input[$field.'_betina'] ?? 0);
            }

            foreach (array_keys(self::unggas()) as $field) {
                $data[$field] = self::toInt($input[$field] ?? 0);
            }

            return $data;
        }

        foreach (self::animalColumns() as $column) {
            $data[$column] = self::toInt($input[$column] ?? 0);
        }

        return $data;
    }

    public static function exportRow(object $row, string $jenis): array
    {
        $data = [
            'tanggal' => $row->tanggal,
            'nik' => $row->nik,
            'nama' => $row->nama,
            'kabupaten' => $row->nama_kab_kota ?? '',
            'kecamatan' => $row->nama_kecamatan ?? '',
            'desa_kelurahan' => $row->nama_desa_kel ?? '',
        ];

        if (self::isKelahiran($jenis)) {
            foreach (array_keys(self::mamalia()) as $field) {
                $data[$field.'_jantan'] = self::toInt($row->{$field.'_anak_jantan'} ?? 0);
                $data[$field.'_betina'] = self::toInt($row->{$field.'_anak_betina'} ?? 0);
            }

            foreach (array_keys(self::unggas()) as $field) {
                $data[$field] = self::toInt($row->{$field} ?? 0);
            }
        } else {
            foreach (self::animalColumns() as $column) {
                $data[$column] = self::toInt($row->{$column} ?? 0);
            }
        }

        $data['keterangan'] = $row->keterangan ?? '';

        return $data;
    }

    public static function totalAnimalCount(array $animalData): int
    {
        $total = 0;

        foreach (self::animalColumns() as $column) {
            $total += self::toInt($animalData[$column] ?? 0);
        }

        return $total;
    }

    public static function toInt(mixed $value): int
    {
        if ($value === null || $value === '') {
            return 0;
        }

        return (int) $value;
    }
}

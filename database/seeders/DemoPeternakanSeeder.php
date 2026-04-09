<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoPeternakanSeeder extends Seeder
{
    /**
     * Seed demo master and transaction data for the peternakan app.
     */
    public function run(): void
    {
        $now = now();

        $kabupatenKota = [
            ['id' => 5201, 'provinsi_id' => 52, 'nama_kab_kota' => 'Kabupaten Lombok Barat'],
            ['id' => 5271, 'provinsi_id' => 52, 'nama_kab_kota' => 'Kota Mataram'],
        ];

        $kecamatans = [
            ['id' => 5201010, 'kab_kota_id' => 5201, 'nama_kecamatan' => 'Sekotong'],
            ['id' => 5201020, 'kab_kota_id' => 5201, 'nama_kecamatan' => 'Lembar'],
            ['id' => 5271010, 'kab_kota_id' => 5271, 'nama_kecamatan' => 'Ampenan'],
        ];

        $desaKelurahans = [
            ['id' => 5201010001, 'kecamatan_id' => 5201010, 'nama_desa_kel' => 'Cendi Manik'],
            ['id' => 5201010002, 'kecamatan_id' => 5201010, 'nama_desa_kel' => 'Persiapan Jelateng'],
            ['id' => 5201020001, 'kecamatan_id' => 5201020, 'nama_desa_kel' => 'Labuan Tereng'],
            ['id' => 5271010001, 'kecamatan_id' => 5271010, 'nama_desa_kel' => 'Ampenan Tengah'],
        ];

        foreach ($kabupatenKota as $row) {
            DB::table('kabupaten_kotas')->updateOrInsert(
                ['id' => $row['id']],
                $row + ['created_at' => $now, 'updated_at' => $now]
            );
        }

        foreach ($kecamatans as $row) {
            DB::table('kecamatans')->updateOrInsert(
                ['id' => $row['id']],
                $row + ['created_at' => $now, 'updated_at' => $now]
            );
        }

        foreach ($desaKelurahans as $row) {
            DB::table('desa_kelurahans')->updateOrInsert(
                ['id' => $row['id']],
                $row + ['created_at' => $now, 'updated_at' => $now]
            );
        }

        $users = [
            [
                'email' => 'admin@populasi.test',
                'name' => 'Admin Provinsi',
                'user_type' => 'A',
                'kab_kota_id' => 5201,
                'kecamatan_id' => 5201010,
            ],
            [
                'email' => 'lombokbarat@populasi.test',
                'name' => 'Admin Kabupaten Lombok Barat',
                'user_type' => 'B',
                'kab_kota_id' => 5201,
                'kecamatan_id' => 5201010,
            ],
            [
                'email' => 'sekotong@populasi.test',
                'name' => 'Operator Kecamatan Sekotong',
                'user_type' => 'C',
                'kab_kota_id' => 5201,
                'kecamatan_id' => 5201010,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                $user + [
                    'email_verified_at' => $now,
                    'password' => Hash::make('password'),
                    'remember_token' => null,
                    'current_team_id' => null,
                    'profile_photo_path' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $peternaks = [
            [
                'nik' => '5201010101010001',
                'nama' => 'Ahmad Satria',
                'tempat_lahir' => 'Mataram',
                'tanggal_lahir' => '1985-04-12',
                'jenis_kelamin' => '1',
                'kab_kota_id' => 5201,
                'kecamatan_id' => 5201010,
                'desa_kel_id' => 5201010001,
                'alamat' => 'Dusun Batu Kijuk 1',
                'hp' => '081234560001',
                'pekerjaan' => '2',
            ],
            [
                'nik' => '5201010101010002',
                'nama' => 'Siti Nurbaya',
                'tempat_lahir' => 'Gerung',
                'tanggal_lahir' => '1990-07-18',
                'jenis_kelamin' => '2',
                'kab_kota_id' => 5201,
                'kecamatan_id' => 5201010,
                'desa_kel_id' => 5201010002,
                'alamat' => 'Lingkungan Jelateng 2',
                'hp' => '081234560002',
                'pekerjaan' => '2',
            ],
            [
                'nik' => '5201020202020003',
                'nama' => 'Budi Santoso',
                'tempat_lahir' => 'Lembar',
                'tanggal_lahir' => '1979-11-03',
                'jenis_kelamin' => '1',
                'kab_kota_id' => 5201,
                'kecamatan_id' => 5201020,
                'desa_kel_id' => 5201020001,
                'alamat' => 'Jalan Pelabuhan Lembar 5',
                'hp' => '081234560003',
                'pekerjaan' => '3',
            ],
            [
                'nik' => '5271010303030004',
                'nama' => 'Nur Aini',
                'tempat_lahir' => 'Ampenan',
                'tanggal_lahir' => '1994-01-24',
                'jenis_kelamin' => '2',
                'kab_kota_id' => 5271,
                'kecamatan_id' => 5271010,
                'desa_kel_id' => 5271010001,
                'alamat' => 'Jalan Pabean 10',
                'hp' => '081234560004',
                'pekerjaan' => '4',
            ],
        ];

        foreach ($peternaks as $peternak) {
            DB::table('peternaks')->updateOrInsert(
                ['nik' => $peternak['nik']],
                $peternak + ['created_at' => $now, 'updated_at' => $now]
            );
        }

        $peternakIds = DB::table('peternaks')->pluck('id', 'nik');

        $ternaks = [
            [
                'tahun' => 2025,
                'peternak_nik' => '5201010101010001',
                'sapi_anak_jantan' => 3,
                'sapi_anak_betina' => 4,
                'sapi_muda_jantan' => 2,
                'sapi_muda_betina' => 2,
                'sapi_dewasa_jantan' => 1,
                'sapi_dewasa_betina' => 6,
                'kerbau_anak_jantan' => 0,
                'kerbau_anak_betina' => 1,
                'kerbau_muda_jantan' => 0,
                'kerbau_muda_betina' => 1,
                'kerbau_dewasa_jantan' => 1,
                'kerbau_dewasa_betina' => 2,
                'kuda_anak_jantan' => 0,
                'kuda_anak_betina' => 0,
                'kuda_muda_jantan' => 0,
                'kuda_muda_betina' => 1,
                'kuda_dewasa_jantan' => 0,
                'kuda_dewasa_betina' => 1,
                'kambing_anak_jantan' => 7,
                'kambing_anak_betina' => 8,
                'kambing_muda_jantan' => 4,
                'kambing_muda_betina' => 5,
                'kambing_dewasa_jantan' => 3,
                'kambing_dewasa_betina' => 9,
                'babi_anak_jantan' => 0,
                'babi_anak_betina' => 0,
                'babi_muda_jantan' => 0,
                'babi_muda_betina' => 0,
                'babi_dewasa_jantan' => 0,
                'babi_dewasa_betina' => 0,
                'domba_anak_jantan' => 2,
                'domba_anak_betina' => 3,
                'domba_muda_jantan' => 2,
                'domba_muda_betina' => 2,
                'domba_dewasa_jantan' => 1,
                'domba_dewasa_betina' => 4,
                'ayam_ras' => 80,
                'ayam_buras' => 45,
                'ayam_petelur' => 30,
                'itik' => 16,
                'puyuh' => 25,
                'keterangan' => 'Data demo tahun 2025 untuk peternak unggulan',
            ],
            [
                'tahun' => 2026,
                'peternak_nik' => '5201010101010001',
                'sapi_anak_jantan' => 4,
                'sapi_anak_betina' => 5,
                'sapi_muda_jantan' => 3,
                'sapi_muda_betina' => 2,
                'sapi_dewasa_jantan' => 2,
                'sapi_dewasa_betina' => 7,
                'kerbau_anak_jantan' => 1,
                'kerbau_anak_betina' => 1,
                'kerbau_muda_jantan' => 1,
                'kerbau_muda_betina' => 1,
                'kerbau_dewasa_jantan' => 1,
                'kerbau_dewasa_betina' => 2,
                'kuda_anak_jantan' => 0,
                'kuda_anak_betina' => 1,
                'kuda_muda_jantan' => 0,
                'kuda_muda_betina' => 1,
                'kuda_dewasa_jantan' => 0,
                'kuda_dewasa_betina' => 1,
                'kambing_anak_jantan' => 8,
                'kambing_anak_betina' => 9,
                'kambing_muda_jantan' => 5,
                'kambing_muda_betina' => 6,
                'kambing_dewasa_jantan' => 3,
                'kambing_dewasa_betina' => 10,
                'babi_anak_jantan' => 0,
                'babi_anak_betina' => 0,
                'babi_muda_jantan' => 0,
                'babi_muda_betina' => 0,
                'babi_dewasa_jantan' => 0,
                'babi_dewasa_betina' => 0,
                'domba_anak_jantan' => 3,
                'domba_anak_betina' => 4,
                'domba_muda_jantan' => 2,
                'domba_muda_betina' => 3,
                'domba_dewasa_jantan' => 2,
                'domba_dewasa_betina' => 5,
                'ayam_ras' => 95,
                'ayam_buras' => 52,
                'ayam_petelur' => 34,
                'itik' => 21,
                'puyuh' => 30,
                'keterangan' => 'Produksi meningkat setelah penambahan kandang',
            ],
            [
                'tahun' => 2026,
                'peternak_nik' => '5201010101010002',
                'sapi_anak_jantan' => 2,
                'sapi_anak_betina' => 3,
                'sapi_muda_jantan' => 1,
                'sapi_muda_betina' => 2,
                'sapi_dewasa_jantan' => 1,
                'sapi_dewasa_betina' => 4,
                'kerbau_anak_jantan' => 0,
                'kerbau_anak_betina' => 0,
                'kerbau_muda_jantan' => 0,
                'kerbau_muda_betina' => 1,
                'kerbau_dewasa_jantan' => 0,
                'kerbau_dewasa_betina' => 1,
                'kuda_anak_jantan' => 0,
                'kuda_anak_betina' => 0,
                'kuda_muda_jantan' => 0,
                'kuda_muda_betina' => 0,
                'kuda_dewasa_jantan' => 0,
                'kuda_dewasa_betina' => 0,
                'kambing_anak_jantan' => 6,
                'kambing_anak_betina' => 7,
                'kambing_muda_jantan' => 4,
                'kambing_muda_betina' => 4,
                'kambing_dewasa_jantan' => 2,
                'kambing_dewasa_betina' => 8,
                'babi_anak_jantan' => 0,
                'babi_anak_betina' => 0,
                'babi_muda_jantan' => 0,
                'babi_muda_betina' => 0,
                'babi_dewasa_jantan' => 0,
                'babi_dewasa_betina' => 0,
                'domba_anak_jantan' => 1,
                'domba_anak_betina' => 2,
                'domba_muda_jantan' => 1,
                'domba_muda_betina' => 2,
                'domba_dewasa_jantan' => 1,
                'domba_dewasa_betina' => 3,
                'ayam_ras' => 70,
                'ayam_buras' => 38,
                'ayam_petelur' => 26,
                'itik' => 12,
                'puyuh' => 18,
                'keterangan' => 'Kelompok ternak binaan desa',
            ],
            [
                'tahun' => 2026,
                'peternak_nik' => '5201020202020003',
                'sapi_anak_jantan' => 1,
                'sapi_anak_betina' => 2,
                'sapi_muda_jantan' => 1,
                'sapi_muda_betina' => 1,
                'sapi_dewasa_jantan' => 1,
                'sapi_dewasa_betina' => 3,
                'kerbau_anak_jantan' => 0,
                'kerbau_anak_betina' => 1,
                'kerbau_muda_jantan' => 0,
                'kerbau_muda_betina' => 1,
                'kerbau_dewasa_jantan' => 1,
                'kerbau_dewasa_betina' => 1,
                'kuda_anak_jantan' => 1,
                'kuda_anak_betina' => 0,
                'kuda_muda_jantan' => 1,
                'kuda_muda_betina' => 0,
                'kuda_dewasa_jantan' => 1,
                'kuda_dewasa_betina' => 0,
                'kambing_anak_jantan' => 4,
                'kambing_anak_betina' => 5,
                'kambing_muda_jantan' => 3,
                'kambing_muda_betina' => 4,
                'kambing_dewasa_jantan' => 2,
                'kambing_dewasa_betina' => 5,
                'babi_anak_jantan' => 0,
                'babi_anak_betina' => 0,
                'babi_muda_jantan' => 0,
                'babi_muda_betina' => 0,
                'babi_dewasa_jantan' => 0,
                'babi_dewasa_betina' => 0,
                'domba_anak_jantan' => 2,
                'domba_anak_betina' => 2,
                'domba_muda_jantan' => 1,
                'domba_muda_betina' => 1,
                'domba_dewasa_jantan' => 1,
                'domba_dewasa_betina' => 2,
                'ayam_ras' => 40,
                'ayam_buras' => 22,
                'ayam_petelur' => 12,
                'itik' => 8,
                'puyuh' => 10,
                'keterangan' => 'Peternak campuran wilayah pesisir',
            ],
            [
                'tahun' => 2026,
                'peternak_nik' => '5271010303030004',
                'sapi_anak_jantan' => 0,
                'sapi_anak_betina' => 1,
                'sapi_muda_jantan' => 0,
                'sapi_muda_betina' => 1,
                'sapi_dewasa_jantan' => 0,
                'sapi_dewasa_betina' => 2,
                'kerbau_anak_jantan' => 0,
                'kerbau_anak_betina' => 0,
                'kerbau_muda_jantan' => 0,
                'kerbau_muda_betina' => 0,
                'kerbau_dewasa_jantan' => 0,
                'kerbau_dewasa_betina' => 0,
                'kuda_anak_jantan' => 0,
                'kuda_anak_betina' => 0,
                'kuda_muda_jantan' => 0,
                'kuda_muda_betina' => 0,
                'kuda_dewasa_jantan' => 0,
                'kuda_dewasa_betina' => 0,
                'kambing_anak_jantan' => 3,
                'kambing_anak_betina' => 4,
                'kambing_muda_jantan' => 2,
                'kambing_muda_betina' => 2,
                'kambing_dewasa_jantan' => 1,
                'kambing_dewasa_betina' => 4,
                'babi_anak_jantan' => 0,
                'babi_anak_betina' => 0,
                'babi_muda_jantan' => 0,
                'babi_muda_betina' => 0,
                'babi_dewasa_jantan' => 0,
                'babi_dewasa_betina' => 0,
                'domba_anak_jantan' => 0,
                'domba_anak_betina' => 1,
                'domba_muda_jantan' => 0,
                'domba_muda_betina' => 1,
                'domba_dewasa_jantan' => 0,
                'domba_dewasa_betina' => 1,
                'ayam_ras' => 25,
                'ayam_buras' => 30,
                'ayam_petelur' => 15,
                'itik' => 5,
                'puyuh' => 12,
                'keterangan' => 'Peternak perkotaan skala rumah tangga',
            ],
        ];

        foreach ($ternaks as $ternak) {
            $peternakId = $peternakIds[$ternak['peternak_nik']] ?? null;

            if (! $peternakId) {
                continue;
            }

            unset($ternak['peternak_nik']);

            DB::table('ternaks')->updateOrInsert(
                ['tahun' => $ternak['tahun'], 'peternak_id' => $peternakId],
                $ternak + [
                    'peternak_id' => $peternakId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $verifikasis = [
            [
                'data_type' => 'B',
                'tahun' => 2026,
                'daerah' => 5201,
                'status_pengajuan' => 1,
                'tanggal_pengajuan' => '2026-01-15',
                'status_verifikasi' => 1,
                'tanggal_verifikasi' => '2026-01-18',
            ],
            [
                'data_type' => 'C',
                'tahun' => 2026,
                'daerah' => 5201010,
                'status_pengajuan' => 1,
                'tanggal_pengajuan' => '2026-01-10',
                'status_verifikasi' => 1,
                'tanggal_verifikasi' => '2026-01-12',
            ],
            [
                'data_type' => 'C',
                'tahun' => 2026,
                'daerah' => 5201020,
                'status_pengajuan' => 1,
                'tanggal_pengajuan' => '2026-01-20',
                'status_verifikasi' => 0,
                'tanggal_verifikasi' => '2026-01-22',
            ],
        ];

        foreach ($verifikasis as $verifikasi) {
            DB::table('verifikasis')->updateOrInsert(
                [
                    'data_type' => $verifikasi['data_type'],
                    'tahun' => $verifikasi['tahun'],
                    'daerah' => $verifikasi['daerah'],
                ],
                $verifikasi + ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan status_pengajuan per-baris data ternak:
     *   0 = Belum / Draft (default)
     *   1 = Menunggu Verifikasi (sudah diajukan)
     *   2 = Tervalidasi
     *   3 = Revisi
     */
    public function up(): void
    {
        Schema::table('ternaks', function (Blueprint $table) {
            $table->tinyInteger('status_pengajuan')
                  ->default(0)
                  ->after('keterangan')
                  ->comment('0=draft, 1=menunggu, 2=tervalidasi, 3=revisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ternaks', function (Blueprint $table) {
            $table->dropColumn('status_pengajuan');
        });
    }
};

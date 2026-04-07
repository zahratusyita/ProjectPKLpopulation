<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peternaks', function (Blueprint $table) {
            $table->id();
            $table->string('nik',16);
            $table->string('nama',50);
            $table->string('tempat_lahir',100);
            $table->date('tanggal_lahir');
            $table->char(1);
            $table->integer('kab_kota_id');
            $table->integer('kecamatan_id');
            $table->bigInteger('desa_kel_id');
            $table->string('alamat');
            $table->string('hp',13);
            $table->char('pekerjaan', 1);
            $table->timestamps();

            $table->foreign('kab_kota_id')->references('id')->on('kabupaten_kotas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('desa_kel_id')->references('id')->on('desa_kelurahans')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peternaks');
    }
};

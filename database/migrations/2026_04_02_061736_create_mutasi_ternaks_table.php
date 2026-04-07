<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasi_ternaks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->year('tahun')->nullable();
            $table->string('jenis_mutasi'); // 'kelahiran', 'kematian', 'pemotongan'
            $table->unsignedBigInteger('peternak_id');
            $table->integer('sapi_anak_jantan')->default(0);
            $table->integer('sapi_anak_betina')->default(0);
            $table->integer('sapi_muda_jantan')->default(0);
            $table->integer('sapi_muda_betina')->default(0);
            $table->integer('sapi_dewasa_jantan')->default(0);
            $table->integer('sapi_dewasa_betina')->default(0);
            $table->integer('kerbau_anak_jantan')->default(0);
            $table->integer('kerbau_anak_betina')->default(0);
            $table->integer('kerbau_muda_jantan')->default(0);
            $table->integer('kerbau_muda_betina')->default(0);
            $table->integer('kerbau_dewasa_jantan')->default(0);
            $table->integer('kerbau_dewasa_betina')->default(0);
            $table->integer('kuda_anak_jantan')->default(0);
            $table->integer('kuda_anak_betina')->default(0);
            $table->integer('kuda_muda_jantan')->default(0);
            $table->integer('kuda_muda_betina')->default(0);
            $table->integer('kuda_dewasa_jantan')->default(0);
            $table->integer('kuda_dewasa_betina')->default(0);
            $table->integer('kambing_anak_jantan')->default(0);
            $table->integer('kambing_anak_betina')->default(0);
            $table->integer('kambing_muda_jantan')->default(0);
            $table->integer('kambing_muda_betina')->default(0);
            $table->integer('kambing_dewasa_jantan')->default(0);
            $table->integer('kambing_dewasa_betina')->default(0);
            $table->integer('babi_anak_jantan')->default(0);
            $table->integer('babi_anak_betina')->default(0);
            $table->integer('babi_muda_jantan')->default(0);
            $table->integer('babi_muda_betina')->default(0);
            $table->integer('babi_dewasa_jantan')->default(0);
            $table->integer('babi_dewasa_betina')->default(0);
            $table->integer('domba_anak_jantan')->default(0);
            $table->integer('domba_anak_betina')->default(0);
            $table->integer('domba_muda_jantan')->default(0);
            $table->integer('domba_muda_betina')->default(0);
            $table->integer('domba_dewasa_jantan')->default(0);
            $table->integer('domba_dewasa_betina')->default(0);
            $table->integer('ayam_ras')->default(0);
            $table->integer('ayam_buras')->default(0);
            $table->integer('ayam_petelur')->default(0);
            $table->integer('itik')->default(0);
            $table->integer('puyuh')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('peternak_id')->references('id')->on('peternaks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_ternaks');
    }
};

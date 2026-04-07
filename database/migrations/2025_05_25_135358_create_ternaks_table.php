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
        Schema::create('ternaks', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->unsignedBigInteger('peternak_id');
            $table->integer('sapi_anak_jantan');
            $table->integer('sapi_anak_betina');
            $table->integer('sapi_muda_jantan');
            $table->integer('sapi_muda_betina');
            $table->integer('sapi_dewasa_jantan');
            $table->integer('sapi_dewasa_betina');
            $table->integer('kerbau_anak_jantan');
            $table->integer('kerbau_anak_betina');
            $table->integer('kerbau_muda_jantan');
            $table->integer('kerbau_muda_betina');
            $table->integer('kerbau_dewasa_jantan');
            $table->integer('kerbau_dewasa_betina');
            $table->integer('kuda_anak_jantan');
            $table->integer('kuda_anak_betina');
            $table->integer('kuda_muda_jantan');
            $table->integer('kuda_muda_betina');
            $table->integer('kuda_dewasa_jantan');
            $table->integer('kuda_dewasa_betina');
            $table->integer('kambing_anak_jantan');
            $table->integer('kambing_anak_betina');
            $table->integer('kambing_muda_jantan');
            $table->integer('kambing_muda_betina');
            $table->integer('kambing_dewasa_jantan');
            $table->integer('kambing_dewasa_betina');
            $table->integer('babi_anak_jantan');
            $table->integer('babi_anak_betina');
            $table->integer('babi_muda_jantan');
            $table->integer('babi_muda_betina');
            $table->integer('babi_dewasa_jantan');
            $table->integer('babi_dewasa_betina');
            $table->integer('domba_anak_jantan');
            $table->integer('domba_anak_betina');
            $table->integer('domba_muda_jantan');
            $table->integer('domba_muda_betina');
            $table->integer('domba_dewasa_jantan');
            $table->integer('domba_dewasa_betina');
            $table->integer('ayam_ras');
            $table->integer('ayam_buras');
            $table->integer('ayam_petelur');
            $table->integer('itik');
            $table->integer('puyuh');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('peternak_id')->references('id')->on('peternaks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ternaks');
    }
};

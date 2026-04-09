<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutasi_ternaks', function (Blueprint $table) {
            $table->boolean('applied_to_ternak')->default(false)->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('mutasi_ternaks', function (Blueprint $table) {
            $table->dropColumn('applied_to_ternak');
        });
    }
};

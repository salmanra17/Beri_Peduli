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
        Schema::table('kampanyes', function (Blueprint $table) {
            $table->string('jenis_akun')->nullable()->default('perorangan');
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_memegang_ktp')->nullable();
            $table->string('bank_penyaluran')->nullable();
            $table->string('nomor_rekening')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kampanyes', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_akun',
                'no_hp',
                'alamat',
                'foto_memegang_ktp',
                'bank_penyaluran',
                'nomor_rekening',
            ]);
        });
    }
};

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
        Schema::create('penarikan_danas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kampanye_id')->nullable()->constrained('kampanyes')->nullOnDelete();
            $table->string('kode_transaksi')->unique();
            $table->decimal('jumlah', 15, 2);
            $table->string('bank_tujuan');
            $table->string('nomor_rekening');
            $table->string('nama_pemilik_rekening');
            $table->enum('status', ['berhasil', 'diproses', 'ditolak'])->default('diproses');
            $table->text('alasan_penolakan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan_danas');
    }
};

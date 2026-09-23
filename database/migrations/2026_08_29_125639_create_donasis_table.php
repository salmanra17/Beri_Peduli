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
        Schema::create('donasis', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('kampanye_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('jumlah_donasi', 12, 2);

            $table->string('metode_pembayaran');

            $table->enum('status_pembayaran', [
                'menunggu',
                'berhasil',
                'gagal',

            ])->default('menunggu');

            $table->text('pesan')
                ->nullable();

            $table->boolean('anonim')
                ->default(false);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};

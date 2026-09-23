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
        Schema::create('kampanyes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('judul');

            $table->text('deskripsi');

            $table->string('kategori');

            $table->string('lokasi')->nullable();

            $table->decimal('target_dana', 12, 2);

            $table->decimal('dana_terkumpul', 12, 2)
                ->default(0);

            $table->date('batas_tanggal');

            $table->enum('status', [
                'menunggu',
                'aktif',
                'selesai',
            ])->default('menunggu');

            $table->string('gambar')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kampanyes');
    }
};

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
            $table->string('judul_en')->nullable()->after('judul');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kampanyes', function (Blueprint $table) {
            $table->dropColumn(['judul_en', 'deskripsi_en']);
        });
    }
};

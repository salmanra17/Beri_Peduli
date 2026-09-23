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
        Schema::table('komentars', function (Blueprint $table) {
            $table->foreignId('donasi_id')
                ->nullable()
                ->after('kampanye_id')
                ->constrained('donasis')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komentars', function (Blueprint $table) {
            $table->dropForeign(['donasi_id']);
            $table->dropColumn('donasi_id');
        });
    }
};

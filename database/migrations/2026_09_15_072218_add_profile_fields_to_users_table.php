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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_depan')->nullable()->after('name');
            $table->string('nama_belakang')->nullable()->after('nama_depan');
            $table->date('tanggal_lahir')->nullable()->after('alamat');
            $table->string('provinsi')->nullable()->after('tanggal_lahir');
            $table->string('kota')->nullable()->after('provinsi');
            $table->string('kode_pos', 10)->nullable()->after('kota');
            $table->string('foto_profil')->nullable()->after('kode_pos');
            $table->string('bahasa', 10)->default('id')->after('foto_profil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nama_depan',
                'nama_belakang',
                'tanggal_lahir',
                'provinsi',
                'kota',
                'kode_pos',
                'foto_profil',
                'bahasa',
            ]);
        });
    }
};

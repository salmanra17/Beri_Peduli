<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE kampanyes 
                MODIFY status ENUM('menunggu', 'aktif', 'ditolak', 'selesai') 
                NOT NULL DEFAULT 'menunggu'
            ");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE kampanyes 
                MODIFY status ENUM('menunggu', 'aktif', 'selesai') 
                NOT NULL DEFAULT 'menunggu'
            ");
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cari nama foreign key constraint yang sebenarnya
        $constraintName = DB::selectOne("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'jadwal_kegiatan' 
            AND COLUMN_NAME = 'medis_user_id' 
            AND CONSTRAINT_NAME != 'PRIMARY'
            LIMIT 1
        ");

        // Drop constraint jika ada
        if ($constraintName && isset($constraintName->CONSTRAINT_NAME)) {
            $constraint = $constraintName->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE `jadwal_kegiatan` DROP FOREIGN KEY `{$constraint}`");
        }

        // Ubah kolom jadi nullable
        Schema::table('jadwal_kegiatan', function (Blueprint $table) {
            $table->unsignedBigInteger('medis_user_id')->nullable()->change();
        });

        // Tambah foreign key constraint lagi
        Schema::table('jadwal_kegiatan', function (Blueprint $table) {
            $table->foreign('medis_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Cari nama foreign key constraint yang sebenarnya
        $constraintName = DB::selectOne("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'jadwal_kegiatan' 
            AND COLUMN_NAME = 'medis_user_id' 
            AND CONSTRAINT_NAME != 'PRIMARY'
            LIMIT 1
        ");

        // Drop constraint jika ada
        if ($constraintName && isset($constraintName->CONSTRAINT_NAME)) {
            $constraint = $constraintName->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE `jadwal_kegiatan` DROP FOREIGN KEY `{$constraint}`");
        }

        // Ubah kolom jadi not null
        Schema::table('jadwal_kegiatan', function (Blueprint $table) {
            $table->unsignedBigInteger('medis_user_id')->nullable(false)->change();
        });

        // Tambah foreign key constraint lagi
        Schema::table('jadwal_kegiatan', function (Blueprint $table) {
            $table->foreign('medis_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};


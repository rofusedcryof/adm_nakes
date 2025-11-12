<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_kegiatan', function (Blueprint $table) {
            // Tambah kolom sesuai ERD
            $table->string('id_jadwal')->unique()->after('id');
            $table->date('tanggal')->nullable()->after('lansia_id');
            $table->time('waktu')->nullable()->after('tanggal');
            $table->string('aktivitas')->nullable()->after('waktu');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kegiatan', function (Blueprint $table) {
            $table->dropColumn(['id_jadwal', 'tanggal', 'waktu', 'aktivitas']);
        });
    }
};


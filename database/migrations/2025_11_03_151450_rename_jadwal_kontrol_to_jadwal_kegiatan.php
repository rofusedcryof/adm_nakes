<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('jadwal_kontrol') && !Schema::hasTable('jadwal_kegiatan')) {
            Schema::rename('jadwal_kontrol', 'jadwal_kegiatan');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('jadwal_kegiatan') && !Schema::hasTable('jadwal_kontrol')) {
            Schema::rename('jadwal_kegiatan', 'jadwal_kontrol');
        }
    }
};



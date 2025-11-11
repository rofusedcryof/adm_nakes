<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instruksi_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->cascadeOnDelete();
            $table->foreignId('medis_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_obat');
            $table->string('dosis')->nullable();
            $table->string('frekuensi')->nullable();
            $table->date('mulai_pada')->nullable();
            $table->date('selesai_pada')->nullable();
            $table->string('status')->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruksi_obat');
    }
};



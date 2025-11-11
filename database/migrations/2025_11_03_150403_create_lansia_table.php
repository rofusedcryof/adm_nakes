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
        Schema::create('lansia', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_lansia');
            $table->date('umur');
            $table->string('alamat');
            $table->string('id_lansia');
            $table->string('jenis_kelamin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lansia');
    }
};

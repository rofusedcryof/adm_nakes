<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstruksiObatsTable extends Migration
{
    public function up()
    {
        Schema::create('instruksi_obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansias')->onDelete('cascade');
            $table->foreignId('medis_user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_obat');
            $table->string('dosis')->nullable();
            $table->string('frekuensi')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instruksi_obats');
    }
}
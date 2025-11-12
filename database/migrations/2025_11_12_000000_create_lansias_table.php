<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLansiasTable extends Migration
{
    public function up()
    {
        Schema::create('lansias', function (Blueprint $table) {
            $table->id();
            $table->string('id_lansia')->unique();
            $table->string('nama_lansia');
            $table->date('umur')->nullable();
            $table->text('alamat')->nullable();
            $table->char('jenis_kelamin', 1)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lansias');
    }
}
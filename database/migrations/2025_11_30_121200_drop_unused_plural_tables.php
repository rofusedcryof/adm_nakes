<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('instruksi_obats')) {
            Schema::drop('instruksi_obats');
        }
        if (Schema::hasTable('lansias')) {
            Schema::drop('lansias');
        }
    }

    public function down(): void
    {
        // Intentionally left empty; tables dianggap tidak digunakan.
    }
};

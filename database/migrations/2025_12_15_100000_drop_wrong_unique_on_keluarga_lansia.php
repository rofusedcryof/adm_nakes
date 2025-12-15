<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $exists = collect(DB::select("SHOW INDEX FROM keluarga_lansia WHERE Key_name = 'keluarga_lansia_user_unique'"))->isNotEmpty();
        if ($exists) {
            Schema::table('keluarga_lansia', function (Blueprint $table) {
                $table->dropUnique('keluarga_lansia_user_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::table('keluarga_lansia', function (Blueprint $table) {
            $table->unique('keluarga_user_id', 'keluarga_lansia_user_unique');
        });
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Bersihkan data duplikat sebelum menambahkan unique index
        $dups = DB::table('keluarga_lansia')
            ->select('keluarga_user_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('keluarga_user_id')
            ->having('cnt', '>', 1)
            ->get();

        foreach ($dups as $dup) {
            $rows = DB::table('keluarga_lansia')
                ->where('keluarga_user_id', $dup->keluarga_user_id)
                ->orderBy('id')
                ->get();

            // Simpan baris pertama, hapus sisanya
            $keepFirst = true;
            foreach ($rows as $row) {
                if ($keepFirst) { $keepFirst = false; continue; }
                DB::table('keluarga_lansia')->where('id', $row->id)->delete();
            }
        }

        Schema::table('keluarga_lansia', function (Blueprint $table) {
            $table->unique('keluarga_user_id', 'keluarga_lansia_user_unique');
        });
    }

    public function down(): void
    {
        Schema::table('keluarga_lansia', function (Blueprint $table) {
            $table->dropUnique('keluarga_lansia_user_unique');
        });
    }
};

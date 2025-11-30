<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengasuh', function (Blueprint $table) {
            if (!Schema::hasColumn('pengasuh', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
                $table->unique('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengasuh', function (Blueprint $table) {
            if (Schema::hasColumn('pengasuh', 'user_id')) {
                $table->dropUnique(['user_id']);
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};


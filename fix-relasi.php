<?php

/**
 * Script untuk memperbaiki relasi lansia dengan tenaga medis dan keluarga
 * 
 * Cara menggunakan:
 * php fix-relasi.php
 * 
 * Atau via artisan tinker:
 * php artisan tinker
 * require 'fix-relasi.php';
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Lansia;
use Illuminate\Support\Facades\DB;

echo "🔧 Memperbaiki relasi lansia dengan tenaga medis dan keluarga...\n\n";

// Ambil semua data
$medis = User::whereIn('role', ['nakes', 'tenaga_medis'])->get();
$keluarga = User::where('role', 'user')->get();
$lansia = Lansia::all();

if ($medis->isEmpty()) {
    echo "⚠️  Tidak ada tenaga medis ditemukan!\n";
    echo "   Pastikan ada user dengan role 'nakes' atau 'tenaga_medis'\n\n";
} else {
    echo "✅ Ditemukan {$medis->count()} tenaga medis\n";
}

if ($keluarga->isEmpty()) {
    echo "⚠️  Tidak ada keluarga ditemukan!\n";
    echo "   Pastikan ada user dengan role 'user'\n\n";
} else {
    echo "✅ Ditemukan {$keluarga->count()} keluarga\n";
}

if ($lansia->isEmpty()) {
    echo "⚠️  Tidak ada lansia ditemukan!\n";
    echo "   Jalankan seeder terlebih dahulu: php artisan db:seed\n";
    exit(1);
} else {
    echo "✅ Ditemukan {$lansia->count()} lansia\n\n";
}

// Hubungkan semua medis dengan semua lansia
$medisCount = 0;
foreach ($medis as $m) {
    foreach ($lansia as $l) {
        $exists = DB::table('medis_lansia')
            ->where('medis_user_id', $m->id)
            ->where('lansia_id', $l->id)
            ->exists();
        
        if (!$exists) {
            DB::table('medis_lansia')->insert([
                'medis_user_id' => $m->id,
                'lansia_id' => $l->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $medisCount++;
        }
    }
}

// Hubungkan semua keluarga dengan semua lansia
$keluargaCount = 0;
foreach ($keluarga as $k) {
    foreach ($lansia as $l) {
        $exists = DB::table('keluarga_lansia')
            ->where('keluarga_user_id', $k->id)
            ->where('lansia_id', $l->id)
            ->exists();
        
        if (!$exists) {
            DB::table('keluarga_lansia')->insert([
                'keluarga_user_id' => $k->id,
                'lansia_id' => $l->id,
                'hubungan' => 'keluarga',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $keluargaCount++;
        }
    }
}

echo "\n📊 Hasil:\n";
echo "   ✅ Relasi medis-lansia: {$medisCount} relasi baru ditambahkan\n";
echo "   ✅ Relasi keluarga-lansia: {$keluargaCount} relasi baru ditambahkan\n\n";

// Verifikasi
echo "🔍 Verifikasi:\n";
$lansiaSample = $lansia->first();
if ($lansiaSample) {
    $medisCount = $lansiaSample->tenagaMedis->count();
    $keluargaCount = $lansiaSample->keluarga->count();
    echo "   Lansia: {$lansiaSample->nama_lansia}\n";
    echo "   - Tenaga Medis: {$medisCount}\n";
    echo "   - Keluarga: {$keluargaCount}\n\n";
}

echo "✅ Selesai! Relasi berhasil diperbaiki.\n";
echo "   Sekarang pengasuh bisa mengirim notifikasi darurat.\n";


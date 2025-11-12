<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lansia;
use App\Models\RiwayatKondisi;
use App\Models\InstruksiObat;
use App\Models\JadwalKegiatan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Tenaga Medis',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ]
        );

        $keluarga = User::updateOrCreate(
            ['email' => 'keluarga@example.com'],
            [
                'name' => 'Keluarga',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ]
        );

        $medis = User::where('email', 'user@example.com')->first();

        $l1 = Lansia::updateOrCreate(
            ['id_lansia' => 'L-001'],
            ['nama_lansia' => 'Ibu Sari', 'umur' => '1955-03-10', 'alamat' => 'Jl. Melati', 'jenis_kelamin' => 'P']
        );
        $l2 = Lansia::updateOrCreate(
            ['id_lansia' => 'L-002'],
            ['nama_lansia' => 'Bapak Joko', 'umur' => '1950-11-21', 'alamat' => 'Jl. Kenanga', 'jenis_kelamin' => 'L']
        );

        if ($medis) {
            \DB::table('medis_lansia')->updateOrInsert([
                'medis_user_id' => $medis->id,
                'lansia_id' => $l1->id,
            ], []);
        }
        if ($keluarga) {
            \DB::table('keluarga_lansia')->updateOrInsert([
                'keluarga_user_id' => $keluarga->id,
                'lansia_id' => $l1->id,
            ], ['hubungan' => 'anak']);
        }

        RiwayatKondisi::updateOrCreate([
            'lansia_id' => $l1->id,
            'diukur_pada' => now()->subDays(1)->setTime(9,0,0),
        ], [
            'sistol' => 130, 'diastol' => 85, 'nadi' => 78, 'suhu' => 36.8, 'gula_darah' => 110,
        ]);

        if ($medis) {
            InstruksiObat::updateOrCreate([
                'lansia_id' => $l1->id,
                'medis_user_id' => $medis->id,
                'nama_obat' => 'Amlodipine',
            ], [
                'dosis' => '5mg', 'frekuensi' => '1x sehari', 'status' => 'aktif',
            ]);

            JadwalKegiatan::updateOrCreate([
                'lansia_id' => $l1->id,
                'id_jadwal' => 'JDW-' . date('Ymd') . '-001',
            ], [
                'tanggal' => now()->addDays(7),
                'waktu' => '08:30:00',
                'aktivitas' => 'Konsultasi kesehatan rutin',
                'medis_user_id' => $medis->id,
                'lokasi' => 'Puskesmas 1',
                'jadwal_pada' => now()->addDays(7)->setTime(8,30,0),
            ]);
        }
    }
}

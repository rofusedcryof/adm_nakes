<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lansia;
use App\Models\RiwayatKondisi;
use App\Models\InstruksiObat;
use App\Models\JadwalKegiatan;
use App\Models\Admin;
use App\Models\Nakes;
use App\Models\Keluarga;
use App\Models\Pengasuh;
use App\Models\Notifikasi;
use App\Models\JadwalLansia;
use App\Models\RiwayatKondisiLansia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create Admin User
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Tenaga Medis User
        $medis = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Tenaga Medis',
                'password' => Hash::make('123456'),
                'role' => 'nakes',
            ]
        );

        // Create Keluarga User
        $keluargaUser = User::updateOrCreate(
            ['email' => 'keluarga@example.com'],
            [
                'name' => 'Keluarga',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ]
        );
        $pengasuh = User::updateOrCreate(
            ['email' => 'pengasuh@example.com'],
            [
                'name' => 'pengasuh',
                'password' => Hash::make('123456'),
                'role' => 'pengasuh',
            ]
        );




        // Create Admin record
        if ($adminUser) {
            Admin::updateOrCreate(
                ['user_id' => $adminUser->id],
                [
                    'nip' => 'ADM001',
                    'jabatan' => 'Administrator Sistem',
                ]
            );
        }

        // Create Nakes record
        if ($medis) {
            Nakes::updateOrCreate(
                ['user_id' => $medis->id],
                [
                    'nip' => 'NAKES001',
                    'spesialisasi' => 'Dokter Umum',
                    'no_sip' => 'SIP-2024-001',
                ]
            );
        }

        $l1 = Lansia::updateOrCreate(
            ['id_lansia' => 'L-001'],
            ['nama_lansia' => 'Ibu Sari', 'umur' => '1955-03-10', 'alamat' => 'Jl. Melati', 'jenis_kelamin' => 'P']
        );
        $l2 = Lansia::updateOrCreate(
            ['id_lansia' => 'L-002'],
            ['nama_lansia' => 'Bapak Joko', 'umur' => '1950-11-21', 'alamat' => 'Jl. Kenanga', 'jenis_kelamin' => 'L']
        );

        // Hubungkan semua lansia dengan tenaga medis dan keluarga
        if ($medis) {
            // Hubungkan medis dengan l1
            DB::table('medis_lansia')->updateOrInsert([
                'medis_user_id' => $medis->id,
                'lansia_id' => $l1->id,
            ], []);
            // Hubungkan medis dengan l2 juga
            DB::table('medis_lansia')->updateOrInsert([
                'medis_user_id' => $medis->id,
                'lansia_id' => $l2->id,
            ], []);
        }
        if ($keluargaUser) {
            // Hubungkan keluarga dengan l1
            DB::table('keluarga_lansia')->updateOrInsert([
                'keluarga_user_id' => $keluargaUser->id,
                'lansia_id' => $l1->id,
            ], ['hubungan' => 'anak']);
            // Hubungkan keluarga dengan l2 juga
            DB::table('keluarga_lansia')->updateOrInsert([
                'keluarga_user_id' => $keluargaUser->id,
                'lansia_id' => $l2->id,
            ], ['hubungan' => 'anak']);

            // Create Keluarga record
            Keluarga::updateOrCreate(
                ['email' => 'keluarga@example.com'],
                [
                    'nama' => 'Keluarga',
                    'alamat' => 'Jl. Melati No. 10',
                    'no_telepon' => '08123456789',
                    'hubungan' => 'anak',
                    'lansia_id' => $l1->id,
                ]
            );
        }

        // Create Pengasuh
        $pengasuh = Pengasuh::updateOrCreate(
            ['email' => 'pengasuh@example.com'],
            [
                'nama' => 'Siti Nurhaliza',
                'alamat' => 'Jl. Anggrek No. 5',
                'no_telepon' => '08123456788',
                'password' => '123456',
            ]
        );

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
                'dosis' => '5mg', 
                'frekuensi' => '1x sehari', 
                'status' => 'aktif',
                'mulai_pada' => now()->subDays(7),
                'selesai_pada' => now()->addDays(30),
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

        // Create JadwalLansia
        JadwalLansia::updateOrCreate(
            ['id_jadwal' => 'JDL-' . date('Ymd') . '-001'],
            [
                'lansia_id' => $l1->id,
                'tanggal' => now()->addDays(3),
                'waktu' => '10:00:00',
                'aktivitas' => 'Senam lansia',
                'lokasi' => 'Posyandu',
                'catatan' => 'Bawa botol minum',
            ]
        );

        // Create RiwayatKondisiLansia
        RiwayatKondisiLansia::updateOrCreate([
            'lansia_id' => $l1->id,
            'diukur_pada' => now()->subDays(2)->setTime(10,0,0),
        ], [
            'sistol' => 125,
            'diastol' => 80,
            'nadi' => 72,
            'suhu' => 36.5,
            'gula_darah' => 105,
            'catatan' => 'Kondisi stabil',
        ]);

        // Create Notifikasi
        if ($medis) {
            Notifikasi::updateOrCreate([
                'user_id' => $medis->id,
                'tipe' => 'reminder',
                'pesan' => 'Jadwal kontrol Ibu Sari dalam 7 hari',
            ], [
                'data_json' => ['lansia_id' => $l1->id, 'jadwal_id' => 'JDW-' . date('Ymd') . '-001'],
                'read_at' => null,
            ]);
        }

        if ($keluargaUser) {
            Notifikasi::updateOrCreate([
                'user_id' => $keluargaUser->id,
                'tipe' => 'info',
                'pesan' => 'Riwayat kondisi Ibu Sari telah diperbarui',
            ], [
                'data_json' => ['lansia_id' => $l1->id],
                'read_at' => null,
            ]);
        }
    }
}

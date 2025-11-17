<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\Notifikasi;
use App\Models\RiwayatKondisi;
use App\Models\InstruksiObat;
use Illuminate\Http\Request;

class MedisDashboardController extends Controller
{
    /**
     * Dashboard tenaga medis
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Ambil lansia yang di-handle oleh tenaga medis ini
        $lansia = $user->lansiaMedis()->orderBy('nama_lansia')->get();
        
        // Ambil notifikasi darurat yang belum dibaca
        $notifikasiDarurat = Notifikasi::where('user_id', $user->id)
            ->where('tipe', 'emergency')
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        // Ambil kondisi darurat dari lansia yang di-handle
        $kondisiDarurat = RiwayatKondisi::whereIn('lansia_id', $lansia->pluck('id'))
            ->where(function($query) {
                $query->where('sistol', '>', 180)
                    ->orWhere('sistol', '<', 90)
                    ->orWhere('diastol', '>', 120)
                    ->orWhere('diastol', '<', 60)
                    ->orWhere('nadi', '>', 100)
                    ->orWhere('nadi', '<', 60)
                    ->orWhere('suhu', '>', 38.5)
                    ->orWhere('suhu', '<', 36.0)
                    ->orWhere('gula_darah', '>', 200)
                    ->orWhere('gula_darah', '<', 70);
            })
            ->with('lansia')
            ->orderByDesc('diukur_pada')
            ->limit(5)
            ->get();
        
        // Ambil instruksi obat aktif
        $instruksiAktif = InstruksiObat::where('medis_user_id', $user->id)
            ->where('status', 'aktif')
            ->with('lansia')
            ->orderByDesc('mulai_pada')
            ->limit(5)
            ->get();
        
        // Hitung statistik
        $totalLansia = $lansia->count();
        $totalNotifikasi = Notifikasi::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();
        $totalInstruksiAktif = InstruksiObat::where('medis_user_id', $user->id)
            ->where('status', 'aktif')
            ->count();

        return view('medis.dashboard', compact(
            'lansia',
            'notifikasiDarurat',
            'kondisiDarurat',
            'instruksiAktif',
            'totalLansia',
            'totalNotifikasi',
            'totalInstruksiAktif'
        ));
    }
}


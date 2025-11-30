<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lansia;
use App\Models\RiwayatKondisi;
use App\Models\JadwalKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeluargaPortalController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $lansiaList = $user->lansiaKeluarga()->orderBy('nama_lansia')->get();

        $riwayatTerbaru = collect();
        $jadwalMendatang = collect();

        foreach ($lansiaList as $l) {
            $riwayat = $l->riwayatKondisi()->orderByDesc('diukur_pada')->limit(3)->get();
            $riwayatTerbaru = $riwayatTerbaru->concat($riwayat->map(function ($r) use ($l) {
                $r->lansia = $l;
                return $r;
            }));

            $jadwal = $l->jadwalKegiatan()->orderBy('tanggal')->limit(5)->get();
            $jadwalMendatang = $jadwalMendatang->concat($jadwal->map(function ($j) use ($l) {
                $j->lansia = $l;
                return $j;
            }));
        }

        return view('keluarga.dashboard', [
            'lansiaList' => $lansiaList,
            'riwayatTerbaru' => $riwayatTerbaru,
            'jadwalMendatang' => $jadwalMendatang,
        ]);
    }

    public function riwayat(Request $request)
    {
        $user = Auth::user();
        $lansiaList = $user->lansiaKeluarga()->orderBy('nama_lansia')->get();
        $selectedId = $request->get('lansia_id') ?: ($lansiaList->first()->id ?? null);
        if ($selectedId && !$lansiaList->contains('id', $selectedId)) {
            $selectedId = null;
        }

        $riwayat = collect();
        if ($selectedId) {
            $riwayat = RiwayatKondisi::where('lansia_id', $selectedId)
                ->orderByDesc('diukur_pada')
                ->get();
        }

        return view('keluarga.riwayat', compact('lansiaList', 'selectedId', 'riwayat'));
    }

    public function jadwal(Request $request)
    {
        $user = Auth::user();
        $lansiaList = $user->lansiaKeluarga()->orderBy('nama_lansia')->get();
        $selectedId = $request->get('lansia_id') ?: ($lansiaList->first()->id ?? null);
        if ($selectedId && !$lansiaList->contains('id', $selectedId)) {
            $selectedId = null;
        }

        $jadwal = collect();
        if ($selectedId) {
            $jadwal = JadwalKegiatan::where('lansia_id', $selectedId)
                ->orderBy('tanggal')
                ->get();
        }

        return view('keluarga.jadwal', compact('lansiaList', 'selectedId', 'jadwal'));
    }

    public function notifikasi()
    {
        $user = Auth::user();
        $notifikasi = $user->notifikasi()->orderByDesc('created_at')->limit(50)->get();
        return view('keluarga.notifikasi', compact('notifikasi'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('keluarga.profil', compact('user'));
    }

    public function ubahSandi(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        if (!password_verify($validated['password_lama'], $user->password)) {
            return back()->withErrors(['password_lama' => 'Kata sandi lama tidak sesuai.']);
        }

        $user->update(['password' => $validated['password_baru']]);

        return redirect()->route('keluarga.profil')->with('success', 'Kata sandi berhasil diubah.');
    }
}

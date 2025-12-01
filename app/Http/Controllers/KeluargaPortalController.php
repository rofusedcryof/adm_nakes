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
    /* ==========================================
       DASHBOARD
       ========================================== */
    public function dashboard()
    {
        $user = Auth::user();
        $lansiaList = $user->lansiaKeluarga()->orderBy('nama_lansia')->get();

        $riwayatTerbaru  = collect();
        $jadwalMendatang = collect();

        foreach ($lansiaList as $l) {

            // Riwayat terbaru (3 data per lansia)
            $riwayat = $l->riwayatKondisi()
                ->orderByDesc('diukur_pada')
                ->limit(3)
                ->get();

            foreach ($riwayat as $r) {
                $r->lansia = $l;
                $riwayatTerbaru->push($r);
            }

            // Jadwal mendatang (3 data per lansia)
            $jadwal = $l->jadwalKegiatan()
                ->orderBy('tanggal')
                ->limit(3)
                ->get();

            foreach ($jadwal as $j) {
                $j->lansia = $l;
                $jadwalMendatang->push($j);
            }
        }

        return view('keluarga.dashboard', compact(
            'lansiaList',
            'riwayatTerbaru',
            'jadwalMendatang'
        ));
    }

    /* ==========================================
       RIWAYAT KONDISI
       ========================================== */
    public function riwayat(Request $request)
    {
        $user       = Auth::user();
        $lansiaList = $user->lansiaKeluarga()->orderBy('nama_lansia')->get();

        $selectedId = $request->get('lansia_id', 'all');

        if ($selectedId === 'all') {

            $riwayat = RiwayatKondisi::whereIn('lansia_id', $lansiaList->pluck('id'))
                ->with('lansia')
                ->orderByDesc('diukur_pada')
                ->get();

        } else {

            if (!$lansiaList->contains('id', $selectedId)) {
                $selectedId = 'all';
            }

            $riwayat = RiwayatKondisi::where('lansia_id', $selectedId)
                ->with('lansia')
                ->orderByDesc('diukur_pada')
                ->get();
        }

        return view('keluarga.riwayat', compact(
            'lansiaList',
            'selectedId',
            'riwayat'
        ));
    }

    /* ==========================================
       JADWAL KEGIATAN (dengan filter tanggal)
       ========================================== */
    public function jadwal(Request $request)
    {
        $user       = Auth::user();
        $lansiaList = $user->lansiaKeluarga()->orderBy('nama_lansia')->get();

        $selectedId   = $request->get('lansia_id', 'all');
        $selectedDate = $request->get('tanggal', null);
        $reset        = $request->get('reset', null);

        // Jika tombol reset ditekan → hapus tanggal & redirect
        if ($reset) {
            return redirect()->route('keluarga.jadwal', ['lansia_id' => $selectedId]);
        }

        // Query dasar
        $jadwalQuery = JadwalKegiatan::query()
            ->when($selectedId !== 'all', function ($q) use ($selectedId) {
                $q->where('lansia_id', $selectedId);
            })
            ->when($selectedId === 'all', function ($q) use ($lansiaList) {
                $q->whereIn('lansia_id', $lansiaList->pluck('id'));
            });

        // Filter tanggal jika dipilih (format input: YYYY-MM-DD)
        if ($selectedDate) {
            $jadwalQuery->whereDate('tanggal', $selectedDate);
        }

        $jadwal = $jadwalQuery
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get();

        // Pesan jika tidak ada kegiatan di tanggal tersebut
        $emptyMessage = null;
        if ($selectedDate && $jadwal->isEmpty()) {
            $emptyMessage = "Tidak ada kegiatan pada tanggal " .
                \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') . ".";
        }

        return view('keluarga.jadwal', compact(
            'lansiaList',
            'selectedId',
            'selectedDate',
            'jadwal',
            'emptyMessage'
        ));
    }

    /* ==========================================
       NOTIFIKASI
       ========================================== */
    public function notifikasi()
    {
        $user = Auth::user();

        $notifikasi = $user->notifikasi()
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('keluarga.notifikasi', compact('notifikasi'));
    }

    /* ==========================================
       PROFIL
       ========================================== */
    public function profil()
    {
        $user = Auth::user();
        return view('keluarga.profil', compact('user'));
    }

    /* ==========================================
       GANTI KATA SANDI
       ========================================== */
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

        $user->update([
            'password' => bcrypt($validated['password_baru']),
        ]);

        return redirect()
            ->route('keluarga.profil')
            ->with('success', 'Kata sandi berhasil diubah.');
    }
}

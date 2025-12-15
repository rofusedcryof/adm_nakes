<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\RiwayatKondisi;
use App\Models\Notifikasi;
use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\PushNotificationService;

class PengasuhDashboardController extends Controller
{
    public function dashboard()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get();

        $kondisiDarurat = RiwayatKondisi::whereHas('lansia')
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
            ->orderByDesc('diukur_pada')
            ->limit(5)
            ->get();

        return view('pengasuh.dashboard', compact('lansia', 'kondisiDarurat'));
    }

    public function riwayat(Request $request)
    {
        $lansia = Lansia::orderBy('nama_lansia')->get();
        
        $selectedId = $request->get('lansia_id') ?: ($lansia->first()->id ?? null);
        $riwayat = collect();

        if ($selectedId) {
            $riwayat = RiwayatKondisi::where('lansia_id', $selectedId)
                ->orderByDesc('diukur_pada')
                ->get();
        }

        return view('pengasuh.riwayat', compact('lansia', 'selectedId', 'riwayat'));
    }

    public function createUpdate()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get();
        return view('pengasuh.update-kondisi', compact('lansia'));
    }

    /**
     * 
     */public function storeUpdate(Request $request)
{
    $request->validate([
        'lansia_id' => 'required|exists:lansia,id',
        'tanggal' => 'required|date',
        'waktu'   => 'required',
        'sistol' => 'nullable|integer|min:0|max:300',
        'diastol' => 'nullable|integer|min:0|max:200',
        'nadi' => 'nullable|integer|min:0|max:200',
        'suhu' => 'nullable|numeric|min:30|max:45',
        'gula_darah' => 'nullable|integer|min:0|max:500',
        'catatan' => 'nullable|string|max:1000',
    ]);

    // Gabungkan tanggal + waktu
    $diukur_pada = $request->tanggal . ' ' . $request->waktu . ':00';

    RiwayatKondisi::create([
        'lansia_id' => $request->lansia_id,
        'diukur_pada' => $diukur_pada,
        'sistol' => $request->sistol,
        'diastol' => $request->diastol,
        'nadi' => $request->nadi,
        'suhu' => $request->suhu,
        'gula_darah' => $request->gula_darah,
        'catatan' => $request->catatan,
    ]);

    // POPUP 
    return redirect()
        ->route('pengasuh.update-kondisi')
        ->with('success', 'Kondisi lansia berhasil disimpan!');
}


    public function kondisiDarurat()
    {
        $kondisiDarurat = RiwayatKondisi::whereHas('lansia')
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
            ->orderByDesc('diukur_pada')
            ->get();

        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);

        return view('pengasuh.kondisi-darurat', compact('kondisiDarurat', 'lansia'));
    }

    public function kirimNotifikasiDaruratLangsung()
    {
        $semuaLansia = Lansia::all();
        
        if ($semuaLansia->isEmpty()) {
            return redirect()->route('pengasuh.dashboard')
                ->with('warning', 'Belum ada data lansia.');
        }

        $kondisiDarurat = RiwayatKondisi::whereHas('lansia')
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
            ->get()
            ->groupBy('lansia_id')
            ->map(fn($group) => $group->first());

        $jumlahNotifikasi = 0;

        $push = new PushNotificationService();

        if ($kondisiDarurat->isEmpty()) {
            foreach ($semuaLansia as $lansia) {
                $pesan = "🚨 KONDISI DARURAT: {$lansia->nama_lansia} memerlukan bantuan darurat!";
                $data = [
                    'lansia_id' => $lansia->id,
                    'lansia_nama' => $lansia->nama_lansia,
                    'waktu' => now()->format('Y-m-d H:i:s'),
                ];

                $recipientIds = [];
                foreach ($lansia->tenagaMedis as $medis) {
                    Notifikasi::create([
                        'user_id' => $medis->id,
                        'tipe' => 'emergency',
                        'pesan' => $pesan,
                        'data_json' => $data,
                    ]);
                    $recipientIds[] = $medis->id;
                    $jumlahNotifikasi++;
                }

                foreach ($lansia->keluarga as $kel) {
                    Notifikasi::create([
                        'user_id' => $kel->id,
                        'tipe' => 'emergency',
                        'pesan' => $pesan,
                        'data_json' => $data,
                    ]);
                    $recipientIds[] = $kel->id;
                    $jumlahNotifikasi++;
                }

                if (!empty($recipientIds)) {
                    $push->sendToUsers($recipientIds, '🚨 Kondisi Darurat', $pesan, $data);
                }
            }

        } else {
            foreach ($kondisiDarurat as $kondisi) {
                $lansia = $kondisi->lansia;

                $pesan = "🚨 KONDISI DARURAT: {$lansia->nama_lansia} mengalami kondisi berbahaya pada "
                    . $kondisi->diukur_pada->format('d/m/Y H:i');

                $data = [
                    'lansia_id' => $lansia->id,
                    'lansia_nama' => $lansia->nama_lansia,
                    'kondisi_id' => $kondisi->id,
                    'diukur_pada' => $kondisi->diukur_pada,
                    'sistol' => $kondisi->sistol,
                    'diastol' => $kondisi->diastol,
                    'nadi' => $kondisi->nadi,
                    'suhu' => $kondisi->suhu,
                    'gula_darah' => $kondisi->gula_darah,
                ];

                $recipientIds = [];
                foreach ($lansia->tenagaMedis as $medis) {
                    Notifikasi::create([
                        'user_id' => $medis->id,
                        'tipe' => 'emergency',
                        'pesan' => $pesan,
                        'data_json' => $data,
                    ]);
                    $recipientIds[] = $medis->id;
                    $jumlahNotifikasi++;
                }

                foreach ($lansia->keluarga as $kel) {
                    Notifikasi::create([
                        'user_id' => $kel->id,
                        'tipe' => 'emergency',
                        'pesan' => $pesan,
                        'data_json' => $data,
                    ]);
                    $recipientIds[] = $kel->id;
                    $jumlahNotifikasi++;
                }

                if (!empty($recipientIds)) {
                    $push->sendToUsers($recipientIds, '🚨 Kondisi Darurat', $pesan, $data);
                }
            }
        }

        return redirect()->route('pengasuh.dashboard')
            ->with('success', "Notifikasi darurat dikirim ke {$jumlahNotifikasi} penerima.");
    }

    public function kirimNotifikasiDarurat(Request $request)
    {
        $validated = $request->validate([
            'kondisi_id' => ['required','exists:riwayat_kondisi,id'],
            'lansia_id' => ['required','exists:lansia,id'],
        ]);

        $kondisi = RiwayatKondisi::with('lansia')->findOrFail($validated['kondisi_id']);
        $lansia = $kondisi->lansia;

        $pesan = "🚨 KONDISI DARURAT: {$lansia->nama_lansia} pada " . $kondisi->diukur_pada->format('d/m/Y H:i');

        $dataKeluarga = [
            'lansia_id' => $lansia->id,
            'lansia_nama' => $lansia->nama_lansia,
            'kondisi_id' => $kondisi->id,
            'diukur_pada' => $kondisi->diukur_pada,
            'sistol' => $kondisi->sistol,
            'diastol' => $kondisi->diastol,
            'nadi' => $kondisi->nadi,
            'suhu' => $kondisi->suhu,
            'gula_darah' => $kondisi->gula_darah,
            'open_url' => route('keluarga.notifikasi'),
        ];
        $dataMedis = [
            'lansia_id' => $lansia->id,
            'lansia_nama' => $lansia->nama_lansia,
            'kondisi_id' => $kondisi->id,
            'diukur_pada' => $kondisi->diukur_pada,
            'sistol' => $kondisi->sistol,
            'diastol' => $kondisi->diastol,
            'nadi' => $kondisi->nadi,
            'suhu' => $kondisi->suhu,
            'gula_darah' => $kondisi->gula_darah,
            'open_url' => route('medis.notifikasi'),
        ];

        $keluargaIds = [];
        foreach ($lansia->keluarga as $kel) {
            Notifikasi::create([
                'user_id' => $kel->id,
                'tipe' => 'emergency',
                'pesan' => $pesan,
                'data_json' => $dataKeluarga,
            ]);
            $keluargaIds[] = $kel->id;
        }

        $medisIds = [];
        foreach ($lansia->tenagaMedis as $medis) {
            Notifikasi::create([
                'user_id' => $medis->id,
                'tipe' => 'emergency',
                'pesan' => $pesan,
                'data_json' => $dataMedis,
            ]);
            $medisIds[] = $medis->id;
        }

        if (!empty($keluargaIds) || !empty($medisIds)) {
            $push = new PushNotificationService();
            if (!empty($keluargaIds)) {
                $push->sendToUsers($keluargaIds, '🚨 Kondisi Darurat', $pesan, $dataKeluarga);
            }
            if (!empty($medisIds)) {
                $push->sendToUsers($medisIds, '🚨 Kondisi Darurat', $pesan, $dataMedis);
            }
        }

        return redirect()->route('pengasuh.kondisi-darurat')
            ->with('success', 'Notifikasi darurat berhasil dikirim.');
    }

    public function kirimNotifikasiDaruratManual(Request $request)
    {
        $validated = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'pesan'     => ['required','string','max:500'],
        ]);

        $lansia = Lansia::findOrFail($validated['lansia_id']);

        $pesan = $validated['pesan'];

        $dataKeluarga = [
            'lansia_id'   => $lansia->id,
            'lansia_nama' => $lansia->nama_lansia,
            'waktu'       => now()->format('Y-m-d H:i:s'),
            'open_url'    => route('keluarga.notifikasi'),
        ];

        $keluargaIds = [];

        foreach ($lansia->keluarga as $kel) {
            Notifikasi::create([
                'user_id'   => $kel->id,
                'tipe'      => 'emergency',
                'pesan'     => $pesan,
                'data_json' => $dataKeluarga,
            ]);
            $keluargaIds[] = $kel->id;
        }

        $medisIds = [];
        foreach ($lansia->tenagaMedis as $medis) {
            Notifikasi::create([
                'user_id'   => $medis->id,
                'tipe'      => 'emergency',
                'pesan'     => $pesan,
                'data_json' => $dataMedis,
            ]);
            $medisIds[] = $medis->id;
        }

        if (!empty($keluargaIds) || !empty($medisIds)) {
            $push = new PushNotificationService();
            if (!empty($keluargaIds)) {
                $push->sendToUsers($keluargaIds, '🚨 Kondisi Darurat', $pesan, $dataKeluarga);
            }
            if (!empty($medisIds)) {
                $push->sendToUsers($medisIds, '🚨 Kondisi Darurat', $pesan, $dataMedis);
            }
        }

        return redirect()->route('pengasuh.kondisi-darurat')
            ->with('success', 'Notifikasi darurat manual berhasil dikirim.');
    }

    public function notifikasi()
    {
        $items = Notifikasi::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        return view('pengasuh.notifikasi', compact('items'));
    }

    public function profil()
    {
        $pengasuh = auth()->user();
        return view('pengasuh.profil', compact('pengasuh'));
    }


    public function ubahSandi(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()->withErrors(['password_lama' => 'Kata sandi lama tidak sesuai.']);
        }

        $user->update([
            'password' => bcrypt($validated['password_baru']),
        ]);

        return redirect()->route('pengasuh.profil')->with('success', 'Kata sandi berhasil diubah.');
    }
}

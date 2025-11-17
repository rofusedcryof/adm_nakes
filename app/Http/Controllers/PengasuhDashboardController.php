<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\RiwayatKondisi;
use App\Models\Notifikasi;
use App\Models\PushSubscription;
use Illuminate\Http\Request;

class PengasuhDashboardController extends Controller
{
    /**
     * Dashboard pengasuh
     */
    public function dashboard()
    {
        // Ambil semua lansia yang bisa diakses pengasuh
        $lansia = Lansia::orderBy('nama_lansia')->get();
        
        // Ambil kondisi darurat (riwayat dengan nilai abnormal)
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

    /**
     * Tampilkan riwayat kondisi lansia
     */
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

    /**
     * Form untuk update kondisi lansia
     */
    public function createUpdate()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get();
        return view('pengasuh.update-kondisi', compact('lansia'));
    }

    /**
     * Simpan update kondisi lansia
     */
    public function storeUpdate(Request $request)
    {
        $validated = $request->validate([
            'lansia_id' => 'required|exists:lansia,id',
            'diukur_pada' => 'required|date',
            'sistol' => 'nullable|integer|min:0|max:300',
            'diastol' => 'nullable|integer|min:0|max:200',
            'nadi' => 'nullable|integer|min:0|max:200',
            'suhu' => 'nullable|numeric|min:30|max:45',
            'gula_darah' => 'nullable|integer|min:0|max:500',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Convert datetime-local format to datetime
        if (isset($validated['diukur_pada'])) {
            $validated['diukur_pada'] = date('Y-m-d H:i:s', strtotime($validated['diukur_pada']));
        }

        RiwayatKondisi::create($validated);

        return redirect()->route('pengasuh.dashboard')
            ->with('success', 'Kondisi lansia berhasil diperbarui.');
    }

    /**
     * Tampilkan kondisi darurat
     */
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

        return view('pengasuh.kondisi-darurat', compact('kondisiDarurat'));
    }

    /**
     * Kirim notifikasi darurat langsung dari dashboard ke semua tenaga medis dan keluarga
     */
    public function kirimNotifikasiDaruratLangsung()
    {
        // Ambil semua lansia yang ada
        $semuaLansia = Lansia::all();
        
        if ($semuaLansia->isEmpty()) {
            return redirect()->route('pengasuh.dashboard')
                ->with('warning', 'Belum ada data lansia.');
        }

        // Ambil kondisi darurat terbaru untuk setiap lansia
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
            ->map(function ($group) {
                return $group->first(); // Ambil kondisi darurat terbaru untuk setiap lansia
            });

        $jumlahNotifikasi = 0;
        $lansiaTerpilih = [];

        // Jika tidak ada kondisi darurat, kirim notifikasi umum untuk semua lansia
        if ($kondisiDarurat->isEmpty()) {
            foreach ($semuaLansia as $lansia) {
                $pesan = "🚨 KONDISI DARURAT: {$lansia->nama_lansia} memerlukan bantuan darurat! Segera periksa kondisi lansia!";
                $dataNotifikasi = [
                    'lansia_id' => $lansia->id,
                    'lansia_nama' => $lansia->nama_lansia,
                    'waktu' => now()->format('Y-m-d H:i:s'),
                ];

                $tenagaMedis = $lansia->tenagaMedis;
                foreach ($tenagaMedis as $medis) {
                    Notifikasi::create([
                        'user_id' => $medis->id,
                        'tipe' => 'emergency',
                        'pesan' => $pesan,
                        'data_json' => $dataNotifikasi,
                        'read_at' => null,
                    ]);
                    $jumlahNotifikasi++;
                }

                $keluarga = $lansia->keluarga;
                foreach ($keluarga as $kel) {
                    Notifikasi::create([
                        'user_id' => $kel->id,
                        'tipe' => 'emergency',
                        'pesan' => $pesan,
                        'data_json' => $dataNotifikasi,
                        'read_at' => null,
                    ]);
                    $jumlahNotifikasi++;
                }

                if ($tenagaMedis->count() > 0 || $keluarga->count() > 0) {
                    $lansiaTerpilih[] = $lansia->nama_lansia;
                }
            }
        } else {
            // Kirim notifikasi untuk kondisi darurat yang terdeteksi
            foreach ($kondisiDarurat as $kondisi) {
                $lansia = $kondisi->lansia;
                $pesan = "🚨 KONDISI DARURAT: {$lansia->nama_lansia} mengalami kondisi darurat pada " . 
                         $kondisi->diukur_pada->format('d/m/Y H:i') . ". Segera periksa kondisi lansia!";

                $dataNotifikasi = [
                    'lansia_id' => $lansia->id,
                    'lansia_nama' => $lansia->nama_lansia,
                    'kondisi_id' => $kondisi->id,
                    'diukur_pada' => $kondisi->diukur_pada->format('Y-m-d H:i:s'),
                    'sistol' => $kondisi->sistol,
                    'diastol' => $kondisi->diastol,
                    'nadi' => $kondisi->nadi,
                    'suhu' => $kondisi->suhu,
                    'gula_darah' => $kondisi->gula_darah,
                ];

                $tenagaMedis = $lansia->tenagaMedis;
                foreach ($tenagaMedis as $medis) {
                    Notifikasi::create([
                        'user_id' => $medis->id,
                        'tipe' => 'emergency',
                        'pesan' => $pesan,
                        'data_json' => $dataNotifikasi,
                        'read_at' => null,
                    ]);
                    $jumlahNotifikasi++;
                }

                $keluarga = $lansia->keluarga;
                foreach ($keluarga as $kel) {
                    Notifikasi::create([
                        'user_id' => $kel->id,
                        'tipe' => 'emergency',
                        'pesan' => $pesan,
                        'data_json' => $dataNotifikasi,
                        'read_at' => null,
                    ]);
                    $jumlahNotifikasi++;
                }

                if ($tenagaMedis->count() > 0 || $keluarga->count() > 0) {
                    $lansiaTerpilih[] = $lansia->nama_lansia;
                }
            }
        }

        if ($jumlahNotifikasi > 0) {
            return redirect()->route('pengasuh.dashboard')
                ->with('success', "Notifikasi darurat berhasil dikirim ke {$jumlahNotifikasi} penerima (tenaga medis dan keluarga) untuk " . count($lansiaTerpilih) . " lansia!");
        } else {
            return redirect()->route('pengasuh.dashboard')
                ->with('warning', 'Tidak ada tenaga medis atau keluarga yang terkait dengan lansia.');
        }
    }

    /**
     * Kirim notifikasi darurat ke tenaga medis dan keluarga
     */
    public function kirimNotifikasiDarurat(Request $request)
    {
        $validated = $request->validate([
            'kondisi_id' => 'required|exists:riwayat_kondisi,id',
            'lansia_id' => 'required|exists:lansia,id',
        ]);

        $kondisi = RiwayatKondisi::with('lansia')->findOrFail($validated['kondisi_id']);
        $lansia = $kondisi->lansia;

        // Buat pesan notifikasi
        $pesan = "🚨 KONDISI DARURAT: {$lansia->nama_lansia} mengalami kondisi darurat pada " . 
                 $kondisi->diukur_pada->format('d/m/Y H:i') . ". Segera periksa kondisi lansia!";

        // Data tambahan untuk notifikasi
        $dataNotifikasi = [
            'lansia_id' => $lansia->id,
            'lansia_nama' => $lansia->nama_lansia,
            'kondisi_id' => $kondisi->id,
            'diukur_pada' => $kondisi->diukur_pada->format('Y-m-d H:i:s'),
            'sistol' => $kondisi->sistol,
            'diastol' => $kondisi->diastol,
            'nadi' => $kondisi->nadi,
            'suhu' => $kondisi->suhu,
            'gula_darah' => $kondisi->gula_darah,
        ];

        $jumlahNotifikasi = 0;

        // Kirim notifikasi ke semua tenaga medis yang terkait dengan lansia
        $tenagaMedis = $lansia->tenagaMedis;
        foreach ($tenagaMedis as $medis) {
            $notifikasi = Notifikasi::create([
                'user_id' => $medis->id,
                'tipe' => 'emergency',
                'pesan' => $pesan,
                'data_json' => $dataNotifikasi,
                'read_at' => null,
            ]);
            
            // Trigger push notification
            $this->sendPushNotification($medis->id, '🚨 Kondisi Darurat', $pesan, $dataNotifikasi);
            $jumlahNotifikasi++;
        }

        // Kirim notifikasi ke semua keluarga yang terkait dengan lansia
        $keluarga = $lansia->keluarga;
        foreach ($keluarga as $kel) {
            $notifikasi = Notifikasi::create([
                'user_id' => $kel->id,
                'tipe' => 'emergency',
                'pesan' => $pesan,
                'data_json' => $dataNotifikasi,
                'read_at' => null,
            ]);
            
            // Trigger push notification
            $this->sendPushNotification($kel->id, '🚨 Kondisi Darurat', $pesan, $dataNotifikasi);
            $jumlahNotifikasi++;
        }

        if ($jumlahNotifikasi > 0) {
            return redirect()->route('pengasuh.kondisi-darurat')
                ->with('success', "Notifikasi darurat berhasil dikirim ke {$jumlahNotifikasi} penerima (tenaga medis dan keluarga)!");
        } else {
            return redirect()->route('pengasuh.kondisi-darurat')
                ->with('warning', 'Tidak ada tenaga medis atau keluarga yang terkait dengan lansia ini.');
        }
    }

    /**
     * Kirim push notification ke user
     */
    private function sendPushNotification($userId, $title, $message, $data = [])
    {
        // Ambil semua push subscription untuk user ini
        $subscriptions = PushSubscription::where('user_id', $userId)->get();
        
        if ($subscriptions->isEmpty()) {
            return; // User belum subscribe push notification
        }

        // Push notification akan dikirim via JavaScript polling atau WebSocket
        // Untuk implementasi lengkap, install package: composer require minishlink/web-push
        // Dan gunakan VAPID keys untuk mengirim push notification
        
        // Untuk sekarang, kita akan trigger event yang akan di-handle oleh JavaScript
        // User akan menerima notifikasi melalui polling atau real-time update
    }
}


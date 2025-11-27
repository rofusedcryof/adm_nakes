<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\Request;

// =========================================================
// 1. CONTROLLER UNTUK JADWAL KEGIATAN (CODE ANDA)
// =========================================================

class AdminJadwalKegiatanController extends Controller
{
    public function index()
    {
        // Variabel yang dikirim adalah $items, sesuai dengan kode index.blade.php
        $items = JadwalKegiatan::with(['lansia','medis'])->orderByDesc('tanggal')->orderByDesc('waktu')->paginate(10);
        return view('admin.jadwal.home', compact('items'));
    }

    public function create()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        // Asumsi 'tenaga_medis' adalah peran yang memberikan instruksi/jadwal
        $medis = User::where('role','tenaga_medis')->orderBy('name')->get(['id','name']);
        return view('admin.jadwal.form', ['mode' => 'create', 'lansia' => $lansia, 'medis' => $medis, 'item' => new JadwalKegiatan()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'medis_user_id' => ['nullable','exists:users,id'],
            'tanggal' => ['required','date'],
            'waktu' => ['required'],
            'aktivitas' => ['required','string'],
            'lokasi' => ['nullable','string'],
            'status' => ['nullable','string'],
            'catatan' => ['nullable','string'],
    ], [
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'waktu.required' => 'Waktu harus diisi.',
            'aktivitas.required' => 'Aktivitas harus diisi.',
    ]);


        // Generate id_jadwal otomatis
        $today = date('Ymd');

        // Cari id_jadwal terakhir untuk hari ini
        $last = JadwalKegiatan::where('id_jadwal', 'LIKE', "JDW-$today-%")
                ->orderBy('id_jadwal', 'desc')
                ->first();

        // Ambil nomor urut terakhir
        $nextNumber = $last
            ? intval(substr($last->id_jadwal, -3)) + 1
            : 1;

        // Generate id_jadwal baru
        $data['id_jadwal'] = "JDW-$today-" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        
        if (isset($data['tanggal']) && isset($data['waktu'])) {
            $data['jadwal_pada'] = $data['tanggal'] . ' ' . $data['waktu'];
        }
        JadwalKegiatan::create($data);
        return redirect()->route('admin.jadwal.home')->with('ok','Jadwal kegiatan berhasil dibuat.');
    }

    public function edit(JadwalKegiatan $jadwal)
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        $medis = User::where('role','tenaga_medis')->orderBy('name')->get(['id','name']);
        return view('admin.jadwal.form', ['mode' => 'edit', 'lansia' => $lansia, 'medis' => $medis, 'item' => $jadwal]);
    }

    public function update(Request $request, JadwalKegiatan $jadwal)
    {
        $data = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'medis_user_id' => ['nullable','exists:users,id'],
            'tanggal' => ['required','date'],
            'waktu' => ['required'],
            'aktivitas' => ['required','string'],
            'lokasi' => ['nullable','string'],
            'status' => ['nullable','string'],
            'catatan' => ['nullable','string'],
    ], [
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'waktu.required' => 'Waktu harus diisi.',
            'aktivitas.required' => 'Aktivitas harus diisi.',
    ]);

        
        if (isset($data['tanggal']) && isset($data['waktu'])) {
            $data['jadwal_pada'] = $data['tanggal'] . ' ' . $data['waktu'];
        }
        $jadwal->update($data);
        return redirect()->route('admin.jadwal.home')->with('ok','Jadwal kegiatan berhasil diperbarui.');
    }

    public function destroy(JadwalKegiatan $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.home')->with('ok','Jadwal kegiatan berhasil dihapus.');
    }
}

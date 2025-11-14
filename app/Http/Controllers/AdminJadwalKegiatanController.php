<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use App\Models\InstruksiObat; // Asumsi Model untuk Instruksi Obat
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
        return view('admin.jadwal.index', compact('items'));
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
        ]);
        // Generate id_jadwal otomatis
        $data['id_jadwal'] = 'JDW-' . date('Ymd') . '-' . str_pad(JadwalKegiatan::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);
        
        if (isset($data['tanggal']) && isset($data['waktu'])) {
            $data['jadwal_pada'] = $data['tanggal'] . ' ' . $data['waktu'];
        }
        JadwalKegiatan::create($data);
        return redirect()->route('admin.jadwal.index')->with('ok','Jadwal kegiatan berhasil dibuat.');
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
        ]);
        
        if (isset($data['tanggal']) && isset($data['waktu'])) {
            $data['jadwal_pada'] = $data['tanggal'] . ' ' . $data['waktu'];
        }
        $jadwal->update($data);
        return redirect()->route('admin.jadwal.index')->with('ok','Jadwal kegiatan berhasil diperbarui.');
    }

    public function destroy(JadwalKegiatan $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('ok','Jadwal kegiatan berhasil dihapus.');
    }
}


// =========================================================
// 2. CONTROLLER BARU UNTUK INSTRUKSI OBAT
// =========================================================

class AdminInstruksiObatController extends Controller
{
    public function index()
    {
        // Ambil semua instruksi obat dengan relasi lansia dan medis, diurutkan, dan dipaginasi
        $items = InstruksiObat::with(['lansia','medis'])
                               ->orderByDesc('created_at')
                               ->paginate(10);
                               
        // Kirim variabel $items ke view
        return view('admin.instruksi.index', compact('items'));
    }

    public function create()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        $medis = User::where('role','tenaga_medis')->orderBy('name')->get(['id','name']);
        
        return view('admin.instruksi.form', [
            'mode' => 'create', 
            'lansia' => $lansia, 
            'medis' => $medis, 
            'item' => new InstruksiObat()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'nama_obat' => ['required','string','max:255'],
            'dosis' => ['nullable','string','max:100'],
            'frekuensi' => ['nullable','string','max:100'],
            'mulai_pada' => ['nullable','date'],
            'selesai_pada' => ['nullable','date','after_or_equal:mulai_pada'],
            'status' => ['nullable','in:aktif,selesai,ditunda'],
            'medis_user_id' => ['nullable','exists:users,id'],
            'catatan' => ['nullable','string'],
        ]);
        
        // Default status jika tidak ada
        $data['status'] = $data['status'] ?? 'aktif';

        InstruksiObat::create($data);
        
        return redirect()->route('admin.instruksi.index')->with('ok','Instruksi obat berhasil ditambahkan.');
    }

    public function edit(InstruksiObat $instruksi)
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        $medis = User::where('role','tenaga_medis')->orderBy('name')->get(['id','name']);
        
        // Menggunakan $instruksi sebagai $item di view form
        return view('admin.instruksi.form', [
            'mode' => 'edit', 
            'lansia' => $lansia, 
            'medis' => $medis, 
            'item' => $instruksi
        ]);
    }

    public function update(Request $request, InstruksiObat $instruksi)
    {
        $data = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'nama_obat' => ['required','string','max:255'],
            'dosis' => ['nullable','string','max:100'],
            'frekuensi' => ['nullable','string','max:100'],
            'mulai_pada' => ['nullable','date'],
            'selesai_pada' => ['nullable','date','after_or_equal:mulai_pada'],
            'status' => ['nullable','in:aktif,selesai,ditunda'],
            'medis_user_id' => ['nullable','exists:users,id'],
            'catatan' => ['nullable','string'],
        ]);

        $instruksi->update($data);
        
        return redirect()->route('admin.instruksi.index')->with('ok','Instruksi obat berhasil diperbarui.');
    }

    public function destroy(InstruksiObat $instruksi)
    {
        $instruksi->delete();
        
        return redirect()->route('admin.instruksi.index')->with('ok','Instruksi obat berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\Request;

class AdminJadwalKegiatanController extends Controller
{
    public function index()
    {
        $items = JadwalKegiatan::with(['lansia','medis'])->orderByDesc('tanggal')->orderByDesc('waktu')->paginate(10);
        return view('admin.jadwal.index', compact('items'));
    }

    public function create()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
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
        // Set jadwal_pada dari tanggal + waktu jika perlu
        if (isset($data['tanggal']) && isset($data['waktu'])) {
            $data['jadwal_pada'] = $data['tanggal'] . ' ' . $data['waktu'];
        }
        JadwalKegiatan::create($data);
        return redirect()->route('admin.jadwal.index')->with('ok','Jadwal dibuat');
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
        // Set jadwal_pada dari tanggal + waktu jika perlu
        if (isset($data['tanggal']) && isset($data['waktu'])) {
            $data['jadwal_pada'] = $data['tanggal'] . ' ' . $data['waktu'];
        }
        $jadwal->update($data);
        return redirect()->route('admin.jadwal.index')->with('ok','Jadwal diperbarui');
    }

    public function destroy(JadwalKegiatan $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('ok','Jadwal dihapus');
    }
}



<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\Request;

class AdminJadwalKegiatanController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query utama
        $query = JadwalKegiatan::with(['lansia','medis']);

        // Jika ada parameter filter & value
        if ($request->filter && $request->value) {

            // Filter ID Jadwal
            if ($request->filter === 'id') {
                $query->where('id_jadwal', 'LIKE', "%{$request->value}%");
            }

            // Filter Nama Lansia
            if ($request->filter === 'lansia') {
                $query->whereHas('lansia', function ($q) use ($request) {
                    $q->where('nama_lansia', 'LIKE', "%{$request->value}%");
                });
            }

            // Filter Tanggal
            if ($request->filter === 'tanggal') {
                $query->where('tanggal', $request->value);
            }

            // Filter Aktivitas
            if ($request->filter === 'aktivitas') {
                $query->where('aktivitas', 'LIKE', "%{$request->value}%");
            }
        }

        // Default ordering
        $items = $query->orderByDesc('tanggal')->orderByDesc('waktu')->paginate(10);

        return view('admin.jadwal.home', compact('items'));
    }



    public function create()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        $medis = User::where('role','tenaga_medis')->orderBy('name')->get(['id','name']);

        return view('admin.jadwal.form', [
            'mode'  => 'create',
            'lansia'=> $lansia,
            'medis' => $medis,
            'item'  => new JadwalKegiatan()
        ]);
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'lansia_id'     => ['required','exists:lansia,id'],
            'medis_user_id' => ['nullable','exists:users,id'],
            'tanggal'       => ['required','date'],
            'waktu'         => ['required'],
            'aktivitas'     => ['required','string'],
            'lokasi'        => ['nullable','string'],
            'status'        => ['nullable','string'],
            'catatan'       => ['nullable','string'],
        ]);

        // Generate ID otomatis
        $today = date('Ymd');

        $last = JadwalKegiatan::where('id_jadwal', "LIKE", "JDW-$today-%")
                ->orderBy('id_jadwal','desc')->first();

        $nextNumber = $last ? intval(substr($last->id_jadwal, -3)) + 1 : 1;

        $data['id_jadwal'] = "JDW-$today-" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Gabungkan tanggal + waktu
        if ($data['tanggal'] && $data['waktu']) {
            $data['jadwal_pada'] = $data['tanggal'] . ' ' . $data['waktu'];
        }

        JadwalKegiatan::create($data);

        // 🔥 PERBAIKAN DISINI
        return redirect()->route('admin.jadwal.home')->with('success', 'Jadwal kegiatan berhasil dibuat!');
    }



    public function edit(JadwalKegiatan $jadwal)
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        $medis = User::where('role','tenaga_medis')->orderBy('name')->get(['id','name']);

        return view('admin.jadwal.form', [
            'mode'  => 'edit',
            'lansia'=> $lansia,
            'medis' => $medis,
            'item'  => $jadwal
        ]);
    }



    public function update(Request $request, JadwalKegiatan $jadwal)
    {
        $data = $request->validate([
            'lansia_id'     => ['required','exists:lansia,id'],
            'medis_user_id' => ['nullable','exists:users,id'],
            'tanggal'       => ['required','date'],
            'waktu'         => ['required'],
            'aktivitas'     => ['required','string'],
            'lokasi'        => ['nullable','string'],
            'status'        => ['nullable','string'],
            'catatan'       => ['nullable','string'],
        ]);

        if ($data['tanggal'] && $data['waktu']) {
            $data['jadwal_pada'] = $data['tanggal'] . ' ' . $data['waktu'];
        }

        $jadwal->update($data);

        // 🔥 PERBAIKAN DISINI
        return redirect()->route('admin.jadwal.home')->with('success', 'Jadwal berhasil diedit!');
    }



    public function destroy(JadwalKegiatan $jadwal)
    {
        $jadwal->delete();

        // 🔥 PERBAIKAN DISINI
        return redirect()->route('admin.jadwal.home')->with('success','Jadwal berhasil dihapus!');
    }
}

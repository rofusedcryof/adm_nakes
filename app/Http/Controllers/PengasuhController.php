<?php

namespace App\Http\Controllers;

use App\Models\Pengasuh;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\JadwalKegiatan;
use App\Models\RiwayatKondisi; 

class PengasuhController extends Controller
{
    public function index()
    {
        $pengasuh = Pengasuh::orderBy('nama')->get();
        return view('admin.pengasuh.index', compact('pengasuh'));
    }

    public function create()
    {
        $item = new Pengasuh();
        return view('admin.pengasuh.form', compact('item'), ['mode' => 'create']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengasuh,email',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        Pengasuh::create($validated);

        return redirect()->route('admin.pengasuh.index')
            ->with('success', 'Data pengasuh berhasil ditambahkan.');
    }

    public function edit(Pengasuh $pengasuh)
    {
        return view('admin.pengasuh.form', compact('pengasuh'), [
            'mode' => 'edit',
            'item' => $pengasuh
        ]);
    }

    public function update(Request $request, Pengasuh $pengasuh)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengasuh,email,' . $pengasuh->id,
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pengasuh->update($validated);

        return redirect()->route('admin.pengasuh.index')
            ->with('success', 'Data pengasuh berhasil diperbarui.');
    }

    public function destroy(Pengasuh $pengasuh)
    {
        $pengasuh->delete();

        return redirect()->route('admin.pengasuh.index')
            ->with('success', 'Data pengasuh berhasil dihapus.');
    }


    /* ============================================================
       FITUR KEGIATAN LANSIA
       ============================================================ */

    public function kegiatanIndex()
    {
        $allLansia = Lansia::all();

        // Ambil semua kegiatan
        $jadwals = JadwalKegiatan::with('lansia')
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('pengasuh.kegiatan-lansia', compact('allLansia', 'jadwals'));
    }

    public function kegiatanShow($id_lansia)
    {
        $allLansia = Lansia::all();

        $lansia = Lansia::where('id_lansia', $id_lansia)->first();
        $jadwals = collect();

        if ($lansia) {
            $jadwals = JadwalKegiatan::where('lansia_id', $lansia->id)
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('pengasuh.kegiatan-lansia', compact('allLansia', 'jadwals', 'lansia'));
    }



    /* ============================================================
       FITUR RIWAYAT KONDISI LANSIA 
       ============================================================ */

    public function riwayat(Request $request)
    {
        // Ambil semua lansia untuk dropdown
        $allLansia = Lansia::orderBy('nama_lansia')->get();

        // Default pilih lansia pertama jika belum dipilih
        $id_lansia = $request->id_lansia ?? ($allLansia->first()->id_lansia ?? null);

        // Ambil data lansia terpilih
        $lansia = Lansia::where('id_lansia', $id_lansia)->first();

        $riwayat = collect();

        if ($lansia) {
            $riwayat = RiwayatKondisi::where('lansia_id', $lansia->id)
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('pengasuh.riwayat', compact(
            'allLansia',
            'lansia',
            'riwayat'
        ));
    }
}

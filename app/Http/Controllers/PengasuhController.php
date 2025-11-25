<?php

namespace App\Http\Controllers;

use App\Models\Pengasuh;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\JadwalLansia;
use App\Models\JadwalKegiatan;


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
        return redirect()->route('admin.pengasuh.index')->with('success', 'Data pengasuh berhasil ditambahkan.');
    }

    public function edit(Pengasuh $pengasuh)
    {
        return view('admin.pengasuh.form', compact('pengasuh'), ['mode' => 'edit', 'item' => $pengasuh]);
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
        return redirect()->route('admin.pengasuh.index')->with('success', 'Data pengasuh berhasil diperbarui.');
    }

    public function destroy(Pengasuh $pengasuh)
    {
        $pengasuh->delete();
        return redirect()->route('admin.pengasuh.index')->with('success', 'Data pengasuh berhasil dihapus.');
    }

    public function kegiatanIndex()
    {
        $allLansia = Lansia::all();
        return view('pengasuh.kegiatan-lansia', compact('allLansia'));
    }

    public function kegiatanShow($id_lansia)
    {
        $allLansia = Lansia::all();
        
        // Cari lansia berdasarkan kode unik id_lansia
        $lansia = Lansia::where('id_lansia', $id_lansia)->first();

        $jadwals = collect();
        if ($lansia) {
            // Query menggunakan id (integer) bukan id_lansia (string)
            $jadwals = JadwalKegiatan::where('lansia_id', $lansia->id)
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('pengasuh.kegiatan-lansia', compact('allLansia', 'lansia', 'jadwals'));
    }
}


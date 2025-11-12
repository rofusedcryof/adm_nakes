<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Lansia;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    public function index()
    {
        $keluarga = Keluarga::with('lansia')->orderBy('nama')->get();
        return view('admin.keluarga.index', compact('keluarga'));
    }

    public function create()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get();
        $item = new Keluarga();
        return view('admin.keluarga.form', compact('lansia', 'item'), ['mode' => 'create']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:keluarga,email',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'hubungan' => 'required|string|max:50',
            'lansia_id' => 'required|exists:lansia,id',
        ]);

        Keluarga::create($validated);
        return redirect()->route('admin.keluarga.index')->with('success', 'Data keluarga berhasil ditambahkan.');
    }

    public function edit(Keluarga $keluarga)
    {
        $lansia = Lansia::orderBy('nama_lansia')->get();
        return view('admin.keluarga.form', compact('keluarga', 'lansia'), ['mode' => 'edit', 'item' => $keluarga]);
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:keluarga,email,' . $keluarga->id,
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'hubungan' => 'required|string|max:50',
            'lansia_id' => 'required|exists:lansia,id',
        ]);

        $keluarga->update($validated);
        return redirect()->route('admin.keluarga.index')->with('success', 'Data keluarga berhasil diperbarui.');
    }

    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('admin.keluarga.index')->with('success', 'Data keluarga berhasil dihapus.');
    }
}


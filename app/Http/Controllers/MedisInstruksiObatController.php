<?php

namespace App\Http\Controllers;

use App\Models\InstruksiObat;
use App\Models\Lansia;
use Illuminate\Http\Request;

class MedisInstruksiObatController extends Controller
{
    public function index()
    {
        $items = InstruksiObat::with(['lansia'])
            ->where('medis_user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('medis.instruksi.index', compact('items'));
    }

    public function create()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        return view('medis.instruksi.form', ['mode' => 'create', 'lansia' => $lansia, 'item' => new InstruksiObat()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'nama_obat' => ['required','string'],
            'dosis' => ['nullable','string'],
            'frekuensi' => ['nullable','string'],
            'mulai_pada' => ['nullable','date'],
            'selesai_pada' => ['nullable','date'],
            'status' => ['nullable','string'],
            'catatan' => ['nullable','string'],
        ]);
        // Otomatis set medis_user_id dari user yang login
        $data['medis_user_id'] = auth()->id();
        InstruksiObat::create($data);
        return redirect()->route('medis.instruksi.index')->with('ok','Instruksi obat dibuat');
    }

    public function edit(InstruksiObat $instruksi)
    {
        // Pastikan hanya yang buat yang bisa edit
        if ($instruksi->medis_user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengedit instruksi ini');
        }
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        return view('medis.instruksi.form', ['mode' => 'edit', 'lansia' => $lansia, 'item' => $instruksi]);
    }

    public function update(Request $request, InstruksiObat $instruksi)
    {
        // Pastikan hanya yang buat yang bisa update
        if ($instruksi->medis_user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengupdate instruksi ini');
        }
        $data = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'nama_obat' => ['required','string'],
            'dosis' => ['nullable','string'],
            'frekuensi' => ['nullable','string'],
            'mulai_pada' => ['nullable','date'],
            'selesai_pada' => ['nullable','date'],
            'status' => ['nullable','string'],
            'catatan' => ['nullable','string'],
        ]);
        $instruksi->update($data);
        return redirect()->route('medis.instruksi.index')->with('ok','Instruksi obat diperbarui');
    }

    public function destroy(InstruksiObat $instruksi)
    {
        // Pastikan hanya yang buat yang bisa hapus
        if ($instruksi->medis_user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak menghapus instruksi ini');
        }
        $instruksi->delete();
        return redirect()->route('medis.instruksi.index')->with('ok','Instruksi obat dihapus');
    }
}


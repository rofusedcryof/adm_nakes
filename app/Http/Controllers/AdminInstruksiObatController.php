<?php

namespace App\Http\Controllers;

use App\Models\InstruksiObat;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\Request;

class AdminInstruksiObatController extends Controller
{
    public function index()
    {
        $items = InstruksiObat::with(['lansia','medis'])->orderByDesc('created_at')->paginate(10);
        return view('admin.instruksi.index', compact('items'));
    }

    public function create()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        $medis = User::where('role','tenaga_medis')->orderBy('name')->get(['id','name']);
        return view('admin.instruksi.form', ['mode' => 'create', 'lansia' => $lansia, 'medis' => $medis, 'item' => new InstruksiObat()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'medis_user_id' => ['nullable','exists:users,id'],
            'nama_obat' => ['required','string'],
            'dosis' => ['nullable','string'],
            'frekuensi' => ['nullable','string'],
            'mulai_pada' => ['nullable','date'],
            'selesai_pada' => ['nullable','date'],
            'status' => ['nullable','string'],
            'catatan' => ['nullable','string'],
        ]);
        InstruksiObat::create($data);
        return redirect()->route('admin.instruksi.index')->with('ok','Instruksi obat dibuat');
    }

    public function edit(InstruksiObat $instruksi)
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);
        $medis = User::where('role','tenaga_medis')->orderBy('name')->get(['id','name']);
        return view('admin.instruksi.form', ['mode' => 'edit', 'lansia' => $lansia, 'medis' => $medis, 'item' => $instruksi]);
    }

    public function update(Request $request, InstruksiObat $instruksi)
    {
        $data = $request->validate([
            'lansia_id' => ['required','exists:lansia,id'],
            'medis_user_id' => ['nullable','exists:users,id'],
            'nama_obat' => ['required','string'],
            'dosis' => ['nullable','string'],
            'frekuensi' => ['nullable','string'],
            'mulai_pada' => ['nullable','date'],
            'selesai_pada' => ['nullable','date'],
            'status' => ['nullable','string'],
            'catatan' => ['nullable','string'],
        ]);
        $instruksi->update($data);
        return redirect()->route('admin.instruksi.index')->with('ok','Instruksi obat diperbarui');
    }

    public function destroy(InstruksiObat $instruksi)
    {
        $instruksi->delete();
        return redirect()->route('admin.instruksi.index')->with('ok','Instruksi obat dihapus');
    }
}


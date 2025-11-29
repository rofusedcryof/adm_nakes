<?php

namespace App\Http\Controllers;

use App\Models\InstruksiObat;
use App\Models\Lansia;
use Illuminate\Http\Request;

class MedisInstruksiObatController extends Controller
{
    public function index(Request $request)
    {
        $query = InstruksiObat::with(['lansia','medis'])
            ->where('medis_user_id', auth()->id());

        // === Filter ===
        if ($request->filled('filter') && $request->filled('value')) {
            $value = $request->value;

            switch ($request->filter) {
                case 'lansia':
                    $query->whereHas('lansia', function ($q) use ($value) {
                        $q->where('nama_lansia', 'LIKE', "%{$value}%");
                    });
                    break;

                case 'obat':
                    $query->where('nama_obat', 'LIKE', "%{$value}%");
                    break;

                case 'status':
                    $query->where('status', 'LIKE', "%{$value}%");
                    break;

                case 'mulai':
                    // value dari input date (YYYY-MM-DD)
                    $query->whereDate('mulai_pada', $value);
                    break;
            }
        }

        $items = $query
            ->orderByDesc('mulai_pada')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('medis.instruksi.index', compact('items'));
    }

    public function create()
    {
        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);

        return view('medis.instruksi.form', [
            'mode'  => 'create',
            'lansia'=> $lansia,
            'item'  => new InstruksiObat(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lansia_id'   => ['required','exists:lansia,id'],
            'nama_obat'   => ['required','string'],
            'dosis'       => ['nullable','string'],
            'frekuensi'   => ['nullable','string'],
            'mulai_pada'  => ['nullable','date'],
            'selesai_pada'=> ['nullable','date'],
            'status'      => ['nullable','string'],
            'catatan'     => ['nullable','string'],
        ]);

        $data['medis_user_id'] = auth()->id();

        InstruksiObat::create($data);

        return redirect()
            ->route('medis.instruksi.index')
            ->with('ok', 'Instruksi obat berhasil dibuat.');
    }

    public function edit(InstruksiObat $instruksi)
    {
        if ($instruksi->medis_user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengedit instruksi ini');
        }

        $lansia = Lansia::orderBy('nama_lansia')->get(['id','nama_lansia','id_lansia']);

        return view('medis.instruksi.form', [
            'mode'  => 'edit',
            'lansia'=> $lansia,
            'item'  => $instruksi,
        ]);
    }

    public function update(Request $request, InstruksiObat $instruksi)
    {
        if ($instruksi->medis_user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengupdate instruksi ini');
        }

        $data = $request->validate([
            'lansia_id'   => ['required','exists:lansia,id'],
            'nama_obat'   => ['required','string'],
            'dosis'       => ['nullable','string'],
            'frekuensi'   => ['nullable','string'],
            'mulai_pada'  => ['nullable','date'],
            'selesai_pada'=> ['nullable','date'],
            'status'      => ['nullable','string'],
            'catatan'     => ['nullable','string'],
        ]);

        $instruksi->update($data);

        return redirect()
            ->route('medis.instruksi.index')
            ->with('ok', 'Instruksi obat berhasil diperbarui.');
    }

    public function destroy(InstruksiObat $instruksi)
    {
        if ($instruksi->medis_user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak menghapus instruksi ini');
        }

        $instruksi->delete();

        return redirect()
            ->route('medis.instruksi.index')
            ->with('ok', 'Instruksi obat berhasil dihapus.');
    }
}

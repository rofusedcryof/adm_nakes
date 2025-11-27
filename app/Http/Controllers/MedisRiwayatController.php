<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\RiwayatKondisi;
use Illuminate\Http\Request;

class MedisRiwayatController extends Controller
{
    public function index(Request $request)
    {
        $role = auth()->user()->role ?? null;
        if ($role !== 'tenaga_medis' && $role !== 'nakes') {
            return redirect()->route('dashboard');
        }

        $lansia = Lansia::select('id', 'nama_lansia', 'id_lansia')->orderBy('nama_lansia')->get();
        $selectedId = $request->get('lansia_id') ?: ($lansia->first()->id ?? null);
        $riwayat = collect();

        if ($selectedId) {
            $riwayat = RiwayatKondisi::where('lansia_id', $selectedId)
                ->orderByDesc('diukur_pada')
                ->get();
        }

        return view('medis.riwayat', compact('lansia', 'selectedId', 'riwayat'));
    }
}


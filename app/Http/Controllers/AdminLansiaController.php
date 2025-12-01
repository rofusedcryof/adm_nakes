<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\Keluarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLansiaController extends Controller
{
    public function index()
    {
        $items = Lansia::with(['keluarga'])->orderBy('nama_lansia')->paginate(10);
        return view('admin.lansia.index', compact('items'));
    }

    public function create()
    {
        return view('admin.lansia.form', ['mode' => 'create', 'item' => new Lansia()]);
    }

    public function store(Request $request)
    {
        $validatedLansia = $request->validate([
            'id_lansia' => 'required|string|max:50|unique:lansia,id_lansia',
            'nama_lansia' => 'required|string|max:255',
            'umur' => 'nullable|date',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string|in:L,P',
        ]);

        $validatedFamily = $request->validate([
            'keluarga_nama' => 'nullable|string|max:255|required_with:keluarga_email',
            'keluarga_email' => 'nullable|email|unique:users,email',
            'keluarga_no_telepon' => 'nullable|string|max:20',
            'keluarga_alamat' => 'nullable|string',
            'keluarga_hubungan' => 'nullable|string|max:50',
            'keluarga_password' => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($validatedLansia, $validatedFamily, $request) {
            $lansia = Lansia::create($validatedLansia);

            if (!empty($validatedFamily['keluarga_email'])) {
                $user = User::create([
                    'name' => $validatedFamily['keluarga_nama'],
                    'email' => $validatedFamily['keluarga_email'],
                    'password' => Hash::make($validatedFamily['keluarga_password'] ?? '123456'),
                    'role' => 'keluarga',
                ]);

                Keluarga::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'email' => $validatedFamily['keluarga_email'],
                        'nama' => $validatedFamily['keluarga_nama'],
                        'alamat' => $validatedFamily['keluarga_alamat'] ?? '',
                        'no_telepon' => $validatedFamily['keluarga_no_telepon'] ?? '',
                        'hubungan' => $validatedFamily['keluarga_hubungan'] ?? '',
                        'lansia_id' => $lansia->id,
                    ]
                );

                DB::table('keluarga_lansia')->updateOrInsert([
                    'keluarga_user_id' => $user->id,
                    'lansia_id' => $lansia->id,
                ], [
                    'hubungan' => $validatedFamily['keluarga_hubungan'] ?? '',
                ]);
            }
        });

        $msg = !empty($validatedFamily['keluarga_email']) ? 'Lansia dan akun keluarga berhasil dibuat' : 'Lansia berhasil dibuat';
        return redirect()->route('admin.lansia.index')->with('success', $msg);
    }
}

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
    /**
     * Tampilkan daftar lansia
     */
    public function index()
    {
        $items = Lansia::with(['keluarga'])
            ->orderBy('nama_lansia')
            ->paginate(10);

        return view('admin.lansia.index', compact('items'));
    }

    /**
     * Tampilkan form tambah lansia
     */
    public function create()
    {
        return view('admin.lansia.form', [
            'mode' => 'create',
            'item' => new Lansia(),
        ]);
    }

    /**
     * Simpan data lansia (BISA BANYAK LANSIA SEKALIGUS)
     */
    public function store(Request $request)
    {
        /**
         * =========================
         * VALIDASI DATA LANSIA
         * =========================
         */
        $rulesLansia = [
            'lansia' => 'required|array|min:1',

            // 🔴 SEMUA FIELD LANSIA WAJIB
            'lansia.*.id_lansia'     => 'required|string|max:50|distinct|unique:lansia,id_lansia',
            'lansia.*.nama_lansia'   => 'required|string|max:255',
            'lansia.*.umur'          => 'required|date',
            'lansia.*.jenis_kelamin' => 'required|in:L,P',
            'lansia.*.alamat'        => 'required|string',
        ];

        /**
         * =========================
         * VALIDASI AKUN KELUARGA
         * =========================
         */
        $rulesFamily = [
            'keluarga_nama'       => 'nullable|string|max:255|required_with:keluarga_email',
            'keluarga_email'      => 'nullable|email|unique:users,email',
            'keluarga_no_telepon' => 'nullable|string|max:20',
            'keluarga_alamat'     => 'nullable|string',
            'keluarga_hubungan'   => 'nullable|string|max:50',
            'keluarga_password'   => 'nullable|string|min:6',
        ];

        /**
         * =========================
         * PESAN ERROR
         * =========================
         */
        $messages = [
            'lansia.required' => 'Minimal harus ada 1 data lansia',

            'lansia.*.id_lansia.required' => 'ID lansia harus diisi',
            'lansia.*.id_lansia.unique'   => 'ID lansia sudah terdaftar',
            'lansia.*.id_lansia.distinct' => 'ID lansia tidak boleh sama',

            'lansia.*.nama_lansia.required' => 'Nama lansia harus diisi',

            'lansia.*.umur.required' => 'Tanggal lahir harus diisi',
            'lansia.*.umur.date'     => 'Format tanggal lahir tidak valid',

            'lansia.*.jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'lansia.*.jenis_kelamin.in'       => 'Jenis kelamin tidak valid',

            // 🔴 PESAN ERROR ALAMAT
            'lansia.*.alamat.required' => 'Alamat lansia harus diisi',

            // ===== KELUARGA =====
            'keluarga_nama.required_with' => 'Nama keluarga harus diisi jika email keluarga diisi',
            'keluarga_email.email'        => 'Format email keluarga tidak valid',
            'keluarga_email.unique'       => 'Email keluarga sudah terdaftar',
            'keluarga_password.min'       => 'Password keluarga minimal 6 karakter',
        ];

        /**
         * =========================
         * PROSES VALIDASI
         * =========================
         */
        $validated = $request->validate(
            $rulesLansia + $rulesFamily,
            $messages
        );

        $lansiaList = $validated['lansia'];

        /**
         * =========================
         * DATA KELUARGA (OPSIONAL)
         * =========================
         */
        $familyData = [
            'nama'       => $validated['keluarga_nama']       ?? null,
            'email'      => $validated['keluarga_email']      ?? null,
            'no_telepon' => $validated['keluarga_no_telepon'] ?? null,
            'alamat'     => $validated['keluarga_alamat']     ?? null,
            'hubungan'   => $validated['keluarga_hubungan']   ?? null,
            'password'   => $validated['keluarga_password']  ?? '123456',
        ];

        /**
         * =========================
         * SIMPAN KE DATABASE
         * =========================
         */
        DB::transaction(function () use ($lansiaList, $familyData) {

            /**
             * 1. SIMPAN SEMUA LANSIA
             */
            $createdLansias = [];

            foreach ($lansiaList as $data) {
                $createdLansias[] = Lansia::create([
                    'id_lansia'     => $data['id_lansia'],
                    'nama_lansia'   => $data['nama_lansia'],
                    'umur'          => $data['umur'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    // 🔴 WAJIB ADA (TIDAK BOLEH ?? '')
                    'alamat'        => $data['alamat'],
                ]);
            }

            /**
             * 2. JIKA ADA AKUN KELUARGA
             */
            if (!empty($familyData['email'])) {

                $user = User::create([
                    'name'     => $familyData['nama'],
                    'email'    => $familyData['email'],
                    'password' => Hash::make($familyData['password']),
                    'role'     => 'keluarga',
                ]);

                Keluarga::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama'       => $familyData['nama'],
                        'email'      => $familyData['email'],
                        'alamat'     => $familyData['alamat'] ?? '',
                        'no_telepon' => $familyData['no_telepon'] ?? '',
                        'hubungan'   => $familyData['hubungan'] ?? '',
                        'lansia_id'  => $createdLansias[0]->id ?? null,
                    ]
                );

                /**
                 * 3. RELASI KE SEMUA LANSIA
                 */
                foreach ($createdLansias as $lansia) {
                    DB::table('keluarga_lansia')->updateOrInsert(
                        [
                            'keluarga_user_id' => $user->id,
                            'lansia_id'        => $lansia->id,
                        ],
                        [
                            'hubungan' => $familyData['hubungan'] ?? '',
                        ]
                    );
                }
            }
        });

        /**
         * =========================
         * REDIRECT
         * =========================
         */
        return redirect()
            ->route('admin.lansia.index')
            ->with(
                'success',
                !empty($familyData['email'])
                    ? 'Data lansia dan akun keluarga berhasil dibuat'
                    : 'Data lansia berhasil dibuat'
            );
    }
}

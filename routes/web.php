<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminJadwalKegiatanController;
use App\Http\Controllers\AdminInstruksiObatController;
use App\Http\Controllers\MedisInstruksiObatController;

// ============================================================
// 🔹 Default route — arahkan otomatis tergantung login
// ============================================================
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'tenaga_medis' => redirect()->route('medis.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }
    return redirect()->route('login');
});

// ============================================================
// 🔹 Login & Logout
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ============================================================
// 🔹 Dashboard umum (untuk user biasa)
// ============================================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// ============================================================
// 🔹 ADMIN ROUTES
// ============================================================
Route::prefix('admin')
    ->middleware(['auth'])
    ->as('admin.') // ✅ tambahkan name prefix
    ->group(function () {
        Route::get('/', function () {
            if (auth()->user()->role !== 'admin') {
                return redirect()->route('dashboard');
            }
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('/jadwal', AdminJadwalKegiatanController::class)->except(['show']);
        Route::resource('/instruksi', AdminInstruksiObatController::class)->except(['show']);
    });

// ============================================================
// 🔹 TENAGA MEDIS ROUTES
// ============================================================
Route::prefix('medis')
    ->middleware(['auth'])
    ->as('medis.') // ✅ tambahkan name prefix
    ->group(function () {
        Route::get('/', function () {
            if (auth()->user()->role !== 'tenaga_medis') {
                return redirect()->route('dashboard');
            }
            return view('medis.dashboard');
        })->name('dashboard');

        Route::get('/riwayat', function () {
            $lansia = \App\Models\Lansia::select('id', 'nama_lansia', 'id_lansia')
                ->orderBy('nama_lansia')
                ->get();

            $selectedId = request('lansia_id') ?: ($lansia->first()->id ?? null);
            $riwayat = collect();

            if ($selectedId) {
                $riwayat = \App\Models\RiwayatKondisi::where('lansia_id', $selectedId)
                    ->orderByDesc('diukur_pada')
                    ->get();
            }

            return view('medis.riwayat', compact('lansia', 'selectedId', 'riwayat'));
        })->name('riwayat');

        Route::resource('/instruksi', MedisInstruksiObatController::class)->except(['show']);
    });

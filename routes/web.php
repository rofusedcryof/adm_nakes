<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminJadwalKegiatanController;
use App\Http\Controllers\AdminInstruksiObatController;
use App\Http\Controllers\MedisInstruksiObatController;
use App\Http\Controllers\MedisDashboardController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PengasuhController;
use App\Http\Controllers\PengasuhDashboardController;
use App\Http\Controllers\PushNotificationController;

// ============================================================
// 🔹 Default route — arahkan otomatis tergantung login
// ============================================================
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'tenaga_medis', 'nakes' => redirect()->route('medis.dashboard'), // Support both 'tenaga_medis' and 'nakes'
            'pengasuh' => redirect()->route('pengasuh.dashboard'),
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
// 🔹 PUSH NOTIFICATION ROUTES
// ============================================================
Route::prefix('api/push')
    ->middleware(['auth'])
    ->group(function () {
        Route::post('/subscribe', [PushNotificationController::class, 'subscribe'])->name('push.subscribe');
        Route::post('/unsubscribe', [PushNotificationController::class, 'unsubscribe'])->name('push.unsubscribe');
        Route::post('/trigger', [PushNotificationController::class, 'trigger'])->name('push.trigger');
    });

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
    ->as('admin.')
    ->group(function () {
        Route::get('/', function () {
            if (auth()->user()->role !== 'admin') {
                return redirect()->route('dashboard');
            }
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('/jadwal', AdminJadwalKegiatanController::class)
            ->except(['show'])
            ->names([
                'index' => 'jadwal.home',
            ]);
        Route::resource('/instruksi', AdminInstruksiObatController::class)->except(['show']);
    });

// ============================================================
// 🔹 TENAGA MEDIS ROUTES
// ============================================================
Route::prefix('medis')
    ->middleware(['auth'])
    ->as('medis.')
    ->group(function () {
        Route::get('/', [MedisDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/riwayat', function () {
            $role = auth()->user()->role;
            if ($role !== 'tenaga_medis' && $role !== 'nakes') {
                return redirect()->route('dashboard');
            }

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

// ============================================================
// 🔹 PENGASUH ROUTES
// ============================================================
Route::prefix('pengasuh')
    ->middleware(['auth'])
    ->as('pengasuh.')
    ->group(function () {
        Route::get('/', [PengasuhDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/riwayat', [PengasuhDashboardController::class, 'riwayat'])->name('riwayat');
        Route::get('/update-kondisi', [PengasuhDashboardController::class, 'createUpdate'])->name('update-kondisi');
        Route::post('/update-kondisi', [PengasuhDashboardController::class, 'storeUpdate'])->name('update-kondisi.store');
        Route::get('/kondisi-darurat', [PengasuhDashboardController::class, 'kondisiDarurat'])->name('kondisi-darurat');
        Route::post('/kirim-notifikasi-darurat', [PengasuhDashboardController::class, 'kirimNotifikasiDarurat'])->name('kirim-notifikasi-darurat');
        Route::post('/kirim-notifikasi-darurat-langsung', [PengasuhDashboardController::class, 'kirimNotifikasiDaruratLangsung'])->name('kirim-notifikasi-darurat-langsung');
    });

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminJadwalKegiatanController;
use App\Http\Controllers\AdminInstruksiObatController;
use App\Http\Controllers\MedisInstruksiObatController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Auth routes (kembali pakai middleware bawaan)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected route example
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Admin dashboard
Route::get('/admin', function () {
    if ((auth()->user()->role ?? 'user') !== 'admin') {
        return redirect()->route('dashboard');
    }
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

// Admin - CRUD Jadwal Kegiatan Lansia
Route::middleware(['auth'])->group(function () {
    Route::middleware([])->group(function () { // role check sederhana di tiap route
        Route::get('/admin/jadwal', [AdminJadwalKegiatanController::class, 'index'])->name('admin.jadwal.index');
        Route::get('/admin/jadwal/create', [AdminJadwalKegiatanController::class, 'create'])->name('admin.jadwal.create');
        Route::post('/admin/jadwal', [AdminJadwalKegiatanController::class, 'store'])->name('admin.jadwal.store');
        Route::get('/admin/jadwal/{jadwal}/edit', [AdminJadwalKegiatanController::class, 'edit'])->name('admin.jadwal.edit');
        Route::put('/admin/jadwal/{jadwal}', [AdminJadwalKegiatanController::class, 'update'])->name('admin.jadwal.update');
        Route::delete('/admin/jadwal/{jadwal}', [AdminJadwalKegiatanController::class, 'destroy'])->name('admin.jadwal.destroy');
    });
});

// Admin - CRUD Instruksi Obat
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/instruksi', [AdminInstruksiObatController::class, 'index'])->name('admin.instruksi.index');
    Route::get('/admin/instruksi/create', [AdminInstruksiObatController::class, 'create'])->name('admin.instruksi.create');
    Route::post('/admin/instruksi', [AdminInstruksiObatController::class, 'store'])->name('admin.instruksi.store');
    Route::get('/admin/instruksi/{instruksi}/edit', [AdminInstruksiObatController::class, 'edit'])->name('admin.instruksi.edit');
    Route::put('/admin/instruksi/{instruksi}', [AdminInstruksiObatController::class, 'update'])->name('admin.instruksi.update');
    Route::delete('/admin/instruksi/{instruksi}', [AdminInstruksiObatController::class, 'destroy'])->name('admin.instruksi.destroy');
});

// Tenaga medis dashboard
Route::get('/medis', function () {
    if ((auth()->user()->role ?? 'user') !== 'tenaga_medis') {
        return redirect()->route('dashboard');
    }
    return view('medis.dashboard');
})->middleware('auth')->name('medis.dashboard');

// Medis - Riwayat Kondisi Lansia
Route::get('/medis/riwayat', function () {
    if ((auth()->user()->role ?? 'user') !== 'tenaga_medis') {
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
})->middleware('auth')->name('medis.riwayat');

// Medis - CRUD Instruksi Obat
Route::middleware(['auth'])->group(function () {
    Route::get('/medis/instruksi', [MedisInstruksiObatController::class, 'index'])->name('medis.instruksi.index');
    Route::get('/medis/instruksi/create', [MedisInstruksiObatController::class, 'create'])->name('medis.instruksi.create');
    Route::post('/medis/instruksi', [MedisInstruksiObatController::class, 'store'])->name('medis.instruksi.store');
    Route::get('/medis/instruksi/{instruksi}/edit', [MedisInstruksiObatController::class, 'edit'])->name('medis.instruksi.edit');
    Route::put('/medis/instruksi/{instruksi}', [MedisInstruksiObatController::class, 'update'])->name('medis.instruksi.update');
    Route::delete('/medis/instruksi/{instruksi}', [MedisInstruksiObatController::class, 'destroy'])->name('medis.instruksi.destroy');
});

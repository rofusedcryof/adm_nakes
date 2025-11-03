<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    // Data boongan untuk dropdown nama lansia
    $lansiaList = [
        ['username' => 'lansia_001', 'nama' => 'Ibu Sari'],
        ['username' => 'lansia_002', 'nama' => 'Bapak Joko'],
        ['username' => 'lansia_003', 'nama' => 'Ibu Rina'],
    ];
    return view('medis.riwayat', compact('lansiaList'));
})->middleware('auth')->name('medis.riwayat');

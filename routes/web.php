<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return session()->has('auth_user')
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Auth routes (tanpa middleware auth/guest karena kita pakai sesi custom)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected route example (berbasis sesi custom)
Route::get('/dashboard', function () {
    if (!session()->has('auth_user')) {
        return redirect()->route('login');
    }
    return view('dashboard');
})->name('dashboard');

// Admin dashboard (berbasis sesi custom)
Route::get('/admin', function () {
    $user = session('auth_user');
    if (!$user) {
        return redirect()->route('login');
    }
    if (($user['role'] ?? 'user') !== 'admin') {
        return redirect()->route('dashboard');
    }
    return view('admin.dashboard');
})->name('admin.dashboard');

// Tenaga medis dashboard (berbasis sesi custom)
Route::get('/medis', function () {
    $user = session('auth_user');
    if (!$user) {
        return redirect()->route('login');
    }
    if (($user['role'] ?? 'user') !== 'tenaga_medis') {
        return redirect()->route('dashboard');
    }
    return view('medis.dashboard');
})->name('medis.dashboard');

// Medis - Riwayat Kondisi Lansia
Route::get('/medis/riwayat', function () {
    $user = session('auth_user');
    if (!$user) {
        return redirect()->route('login');
    }
    if (($user['role'] ?? 'user') !== 'tenaga_medis') {
        return redirect()->route('dashboard');
    }
    // Data boongan untuk dropdown nama lansia
    $lansiaList = [
        ['username' => 'lansia_001', 'nama' => 'Ibu Sari'],
        ['username' => 'lansia_002', 'nama' => 'Bapak Joko'],
        ['username' => 'lansia_003', 'nama' => 'Ibu Rina'],
    ];
    return view('medis.riwayat', compact('lansiaList'));
})->name('medis.riwayat');

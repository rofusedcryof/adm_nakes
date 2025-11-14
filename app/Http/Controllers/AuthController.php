<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user
     */
    public function login(Request $request)
    {
        // ✅ Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ✅ Cek apakah "remember me" dicentang
        $remember = $request->boolean('remember');

        // ✅ Coba login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = $user->role ?? 'user';

            // ✅ Redirect berdasarkan role
            $redirectTo = match ($role) {
                'admin' => route('admin.dashboard'),
                'tenaga_medis' => route('medis.dashboard'),
                default => route('dashboard'),
            };

            // Jangan pakai tanda kurung ya sayang! ($redirectTo, bukan $redirectTo())
            return redirect()->intended($redirectTo);
        }

        // ❌ Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

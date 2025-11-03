<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Database boongan: daftar user hard-coded
        $fakeUsers = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'password', // plain untuk demo
                'role' => 'admin',
            ],
            [
                'id' => 2,
                'name' => 'Tenaga Medis',
                'email' => 'user@example.com',
                'password' => '123456',
                'role' => 'tenaga_medis',
            ],
        ];

        $matched = null;
        foreach ($fakeUsers as $u) {
            if (strtolower($u['email']) === strtolower($credentials['email']) && $u['password'] === $credentials['password']) {
                $matched = $u;
                break;
            }
        }

        if ($matched) {
            // Simpan user ke sesi manual agar tidak tergantung provider database
            $request->session()->put('auth_user', [
                'id' => $matched['id'],
                'name' => $matched['name'],
                'email' => $matched['email'],
                'role' => $matched['role'] ?? 'user',
            ]);
            $request->session()->regenerate();
            $role = $matched['role'] ?? 'user';
            $target = $role === 'admin' ? route('admin.dashboard') : ($role === 'tenaga_medis' ? route('medis.dashboard') : route('dashboard'));
            return redirect()->intended($target);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Hapus sesi custom dan invalidasi
        $request->session()->forget('auth_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}



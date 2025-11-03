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

        $remember = (bool) $request->boolean('remember');

        if (\Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $role = auth()->user()->role ?? 'user';
            $target = $role === 'admin' ? route('admin.dashboard') : ($role === 'tenaga_medis' ? route('medis.dashboard') : route('dashboard'));
            return redirect()->intended($target);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        \Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}



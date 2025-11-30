@extends('keluarga.layout')

@section('content')
    @if(session('success'))
        <div class="card" style="background:#e9fff1; color:#0f5132;">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:56px; height:56px; background:#ddd; border-radius:50%;"></div>
            <div>
                <div style="font-weight:700;">{{ $user->name }}</div>
                <div style="color:#666;">{{ $user->email }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="grid">
            <button class="btn" onclick="location.href='{{ route('keluarga.profil') }}'">Akun</button>
            <button class="btn" onclick="location.href='{{ route('keluarga.profil') }}'">Privasi</button>
            <button class="btn" onclick="location.href='{{ route('keluarga.notifikasi') }}'">Notifikasi</button>
            <button class="btn" onclick="alert('Hubungi admin untuk bantuan.')">Bantuan</button>
        </div>
    </div>

    <div class="card">
        <h3>Ganti Kata Sandi</h3>
        <form method="POST" action="{{ route('keluarga.profil.ubah-sandi') }}">
            @csrf
            <div style="margin-bottom:8px;">
                <label>Kata sandi lama</label>
                <input type="password" name="password_lama" required>
                @error('password_lama')
                    <div style="color:#b00020; font-size:12px;">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid">
                <div>
                    <label>Kata sandi baru</label>
                    <input type="password" name="password_baru" required>
                    @error('password_baru')
                        <div style="color:#b00020; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label>Konfirmasi kata sandi</label>
                    <input type="password" name="password_baru_confirmation" required>
                </div>
            </div>
            <div style="margin-top:12px;">
                <button type="submit" class="btn">Simpan</button>
            </div>
        </form>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn" style="background:#e53935; width:100%;">Keluar</button>
    </form>
@endsection


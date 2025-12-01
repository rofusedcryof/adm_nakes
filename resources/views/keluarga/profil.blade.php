@extends('keluarga.layout')

@section('content')

<!-- ===================== SUCCESS POPUP ===================== -->
@if(session('success'))
<div class="popup-overlay" id="popupSuccess" style="display:flex;">
    <div class="popup-box">
        <h3 style="color:#2A857D;">Berhasil</h3>
        <p>{{ session('success') }}</p>
        <button onclick="document.getElementById('popupSuccess').style.display='none'" class="popup-button">
            OK
        </button>
    </div>
</div>
@endif



<!-- ===================== PROFILE CARD ===================== -->
<div class="card profile-card">
    <div class="profile-header">
        <div class="avatar"></div>
        <div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
        </div>
    </div>
</div>


<!-- ===================== MENU GRID ===================== -->
<div class="card menu-card">
    <div class="menu-grid">
        <button class="menu-btn" onclick="showSection('mainSection')">Akun</button>
        <button class="menu-btn" onclick="openHelp()">Bantuan</button>
        <button class="menu-btn" onclick="location.href='{{ route('keluarga.notifikasi') }}'">Notifikasi</button>
        <button class="menu-btn" onclick="showSection('passwordSection')">Kata Sandi</button>
    </div>
</div>



<!-- ===================== PASSWORD FORM ===================== -->
<div class="card" id="passwordSection" style="display:none; margin-bottom:90px;">
    <h3 style="margin-bottom:15px;">Ganti Kata Sandi</h3>

    <form method="POST" action="{{ route('keluarga.profil.ubah-sandi') }}">
        @csrf

        <label>Kata sandi lama</label>
        <input type="password" name="password_lama" class="input-field" required>
        @error('password_lama')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <label style="margin-top:12px;">Kata sandi baru</label>
        <input type="password" name="password_baru" class="input-field" required>

        <label style="margin-top:12px;">Konfirmasi kata sandi</label>
        <input type="password" name="password_baru_confirmation" class="input-field" required>

        <button type="submit" class="btn-primary">Simpan</button>
    </form>
</div>



<!-- ===================== LOGOUT BUTTON (PINNED TO BOTTOM) ===================== -->
<div class="logout-container">
    <button onclick="openLogout()" class="btn-danger">Keluar</button>
</div>



<!-- ===================== POPUP BANTUAN ===================== -->
<div id="helpPopup" class="popup-overlay" style="display:none;">
    <div class="popup-box">
        <h3 style="color:#2A857D;">Bantuan</h3>
        <p>Untuk bantuan, silakan hubungi admin melalui WhatsApp resmi.</p>
        <button onclick="closeHelp()" class="popup-button">OK</button>
    </div>
</div>


<!-- ===================== POPUP LOGOUT ===================== -->
<div id="logoutPopup" class="popup-overlay" style="display:none;">
    <div class="popup-box">
        <h3 style="color:#d32f2f;">Keluar?</h3>
        <p>Apakah Anda yakin ingin keluar?</p>

        <div class="popup-actions">
            <button onclick="closeLogout()" class="popup-button">Batal</button>

            <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                @csrf
                <button class="popup-button" style="background:#d32f2f;">Keluar</button>
            </form>
        </div>
    </div>
</div>



<!-- ===================== CSS ===================== -->
<style>

.profile-card { margin-top:10px; }
.profile-header { display:flex; align-items:center; gap:15px; }
.avatar {
    width:60px; height:60px;
    border-radius:50%;
    background:#dfe6e9;
}
.profile-name { font-size:1.05rem; font-weight:700; }
.profile-email { font-size:0.9rem; color:#666; }

.menu-card { margin-top:12px; }

.menu-grid {
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:10px;
}
.menu-btn {
    padding:10px;
    background:#e8f6f3;
    border:none;
    border-radius:12px;
    cursor:pointer;
}
.menu-btn:hover { background:#dff0ec; }

.input-field {
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
}

.btn-primary {
    margin-top:16px;
    width:100%;
    padding:12px;
    background:#2A857D;
    color:white;
    border:none;
    border-radius:10px;
    font-weight:bold;
}

.error-text { font-size:12px; color:#d32f2f; margin-top:3px; }

.logout-container {
    width:100%;
    position:fixed;
    bottom:80px;
    left:50%;
    transform:translateX(-50%);
    max-width:360px;
    padding:0 16px;
}

.btn-danger {
    width:100%;
    padding:12px;
    background:#d32f2f;
    color:white;
    border:none;
    border-radius:10px;
    font-weight:bold;
}



/* POPUP STYLE */
.popup-overlay {
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.45);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:999;
}
.popup-box {
    background:white;
    width:300px;
    padding:20px;
    border-radius:16px;
    text-align:center;
}
.popup-button {
    background:#2A857D;
    border:none;
    color:white;
    padding:10px;
    width:100%;
    border-radius:10px;
    font-weight:bold;
    margin-top:10px;
    cursor:pointer;
}
.popup-actions {
    display:flex;
    gap:10px;
    margin-top:15px;
}
</style>



<!-- ===================== SCRIPT ===================== -->
<script>
function showSection(id) {
    document.getElementById('passwordSection').style.display = 'none';

    if (id === 'passwordSection') {
        document.getElementById('passwordSection').style.display = 'block';
        window.scrollTo({ top: 200, behavior: 'smooth' });
    }
}

function openHelp(){ document.getElementById('helpPopup').style.display='flex'; }
function closeHelp(){ document.getElementById('helpPopup').style.display='none'; }

function openLogout(){ document.getElementById('logoutPopup').style.display='flex'; }
function closeLogout(){ document.getElementById('logoutPopup').style.display='none'; }
</script>

@endsection

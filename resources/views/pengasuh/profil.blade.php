@extends('pengasuh.layout')

@section('content')

<!-- SUCCESS POPUP -->
@if(session('success'))
<div class="popup-overlay" id="popupSuccess" style="display:flex;">
    <div class="popup-box">
        <h3 style="color:#2A857D;">Berhasil</h3>
        <p>{{ session('success') }}</p>
        <button onclick="document.getElementById('popupSuccess').style.display='none'" class="popup-button">OK</button>
    </div>
</div>
@endif


<!-- PROFILE CARD -->
<div class="card profile-card">
    <div class="profile-header">
        <div class="avatar"></div>
        <div>
            <div class="profile-name">{{ $pengasuh->name }}</div>
            <div class="profile-email">{{ $pengasuh->email }}</div>
        </div>
    </div>
</div>


<!-- MENU -->
<div class="card menu-card">
    <div class="menu-grid">
        <button class="menu-btn" onclick="showSection('mainSection')">Akun</button>
        <button class="menu-btn" onclick="openHelp()">Bantuan</button>
        <button class="menu-btn" onclick="location.href='{{ route('pengasuh.notifikasi') }}'">Notifikasi</button>
        <button class="menu-btn" onclick="showSection('passwordSection')">Kata Sandi</button>
    </div>
</div>


<!-- PASSWORD FORM -->
<div class="card" id="passwordSection" style="display:none; margin-bottom:110px;">
    <h3 style="margin-bottom:15px;">Ganti Kata Sandi</h3>

    <form method="POST" action="{{ route('pengasuh.profil.ubah-sandi') }}">
        @csrf

        <label>Kata sandi lama</label>
        <input type="password" name="password_lama" class="input-field" required>

        <label style="margin-top:12px;">Kata sandi baru</label>
        <input type="password" name="password_baru" class="input-field" required>

        <label style="margin-top:12px;">Konfirmasi kata sandi</label>
        <input type="password" name="password_baru_confirmation" class="input-field" required>

        <button type="submit" class="btn-primary">Simpan</button>
    </form>
</div>


<!-- LOGOUT BUTTON -->
<div class="logout-container">
    <button onclick="openLogout()" class="btn-danger">Keluar</button>
</div>


<!-- POPUP BANTUAN (VERTIKAL) -->
<div id="helpPopup" class="popup-overlay" style="display:none;">
    <div class="popup-box">

        <h3 style="color:#2A857D; margin-bottom:10px;">Bantuan</h3>

        <p style="font-size:14px; color:#444; line-height:1.4;">
            Untuk bantuan, silakan hubungi admin melalui WhatsApp resmi.
        </p>

        <a href="https://wa.me/{{ env('SUPPORT_WHATSAPP','628123456789') }}?text=Halo%20Admin%20Health%20Sync%2C%20saya%20butuh%20bantuan"
           target="_blank"
           class="popup-btn wa full-btn">
            Buka WhatsApp
        </a>

        <button onclick="closeHelp()" class="popup-btn cancel full-btn">
            Tutup
        </button>

    </div>
</div>


<!-- POPUP LOGOUT (FIXED) -->
<div id="logoutPopup" class="popup-overlay" style="display:none;">
    <div class="popup-box">

        <h3 style="color:#d32f2f;">Keluar</h3>
        <p>Apakah Anda yakin ingin keluar?</p>

        <div class="popup-actions">
            <button onclick="closeLogout()" class="popup-btn cancel">Batal</button>
            <button onclick="submitLogout()" class="popup-btn logout">Keluar</button>
        </div>

        <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>

    </div>
</div>


<!-- CSS -->
<style>
.card { background:white; border-radius:16px; padding:18px; margin-bottom:16px; box-shadow:0 4px 10px rgba(0,0,0,0.12); }
.profile-header { display:flex; align-items:center; gap:15px; }
.avatar { width:60px; height:60px; border-radius:50%; background:#dfe6e9; }

.menu-grid { display:grid; grid-template-columns:repeat(2, 1fr); gap:10px; }
.menu-btn { padding:10px; background:#e8f6f3; border:none; border-radius:12px; cursor:pointer; }

.input-field { width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; }

.btn-primary { margin-top:16px; width:100%; padding:12px; background:#2A857D; color:white; border:none; border-radius:10px; }

.logout-container { width:100%; position:fixed; bottom:80px; left:50%; transform:translateX(-50%); max-width:360px; padding:0 16px; }

.btn-danger { width:100%; padding:12px; background:#d32f2f; color:white; border:none; border-radius:10px; }


/* POPUP STYLING */
.popup-overlay { position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.45); display:flex; justify-content:center; align-items:center; z-index:999; }
.popup-box { background:white; width:300px; padding:20px; border-radius:16px; text-align:center; }

/* HELP POPUP BUTTONS (VERTICAL) */
.full-btn {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    display: block;
    margin-top: 12px;
    text-align: center;
    text-decoration: none;
    border: none;
}
.popup-btn.wa { background:#25D366; color:white; }
.popup-btn.cancel { background:#2A857D; color:white; }

/* LOGOUT POPUP */
.popup-actions { display:flex; gap:10px; margin-top:15px; }
.popup-btn { flex:1; padding:12px; border:none; border-radius:10px; font-weight:bold; cursor:pointer; }
.popup-btn.logout { background:#d32f2f; color:white; }
</style>


<!-- SCRIPT -->
<script>
function openHelp(){ document.getElementById('helpPopup').style.display='flex'; }
function closeHelp(){ document.getElementById('helpPopup').style.display='none'; }

function openLogout(){ document.getElementById('logoutPopup').style.display='flex'; }
function closeLogout(){ document.getElementById('logoutPopup').style.display='none'; }

function submitLogout(){ document.getElementById('logoutForm').submit(); }

function showSection(id) {
    document.getElementById('passwordSection').style.display = (id === 'passwordSection') ? 'block' : 'none';
}
</script>

@endsection

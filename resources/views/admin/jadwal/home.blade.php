<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Jadwal Kegiatan</title>

<style>
    body {
        margin: 0;
        min-height: 100vh;
        font-family: system-ui, sans-serif;
        background: #f0f9f9;
        padding: 1.5rem;
    }

    /* NAVBAR */
    .topbar {
        background: #2A857D;
        color: #fff;
        padding: 1.5rem 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .brand { font-weight: 900; font-size: 1.5rem; }
    .nav { display: flex; gap: 2rem; align-items: center; width: 100%; }
    .nav-right { display: flex; align-items: center; gap: 1rem; margin-left: auto; }
    .nav a { color: #fff; font-weight: 700; text-decoration: none; }

    /* DROPDOWN FILTER */
    .filter-dropdown { position: relative; display: inline-block; }

    .filter-btn {
        background: #1f2937;
        color: white;
        padding: .45rem .9rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }

    .filter-menu {
        display: none;
        position: absolute;
        right: 0;
        background: #fff;
        min-width: 230px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        border-radius: 10px;
        overflow: hidden;
        z-index: 20;
    }

    .filter-dropdown:hover .filter-menu { display: block; }

    .filter-menu button {
        width: 100%;
        background: none;
        border: none;
        padding: .8rem 1rem;
        text-align: left;
        font-weight: 600;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .filter-menu button:hover {
        background: #2A857D;
        color: #fff;
    }

    /* POPUP GLOBAL */
    .popup {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.45);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 200;
    }

    .popup-box {
        background: white;
        padding: 1.8rem;
        width: 330px;
        border-radius: 12px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.25);
        text-align: center;
    }

    .popup-box input {
        width: 100%;
        padding: .6rem;
        margin-top: 1rem;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .popup-btn {
        width: 100%;
        margin-top: 1rem;
        padding: .6rem;
        background: #2A857D;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }

    .popup-close {
        width: 100%;
        margin-top: .5rem;
        padding: .6rem;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }

    /* PAGE WRAPPER */
    .wrap { display: flex; justify-content: center; }

    /* ============================
       BACKGROUND LOGO WATERMARK
       ============================ */
    .content {
        background: #2A857D;
        border-radius: 15px;
        padding: 2.5rem;
        width: 100%;
        position: relative;
        min-height: calc(100vh - 150px);

        background-image: url('/images/HEALTHSYNC.png');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 420px;  
    }

    .card-overlay {
        position: absolute;
        top: 30px;
        left: 30px;
        right: 30px;
        background: rgba(255,255,255,0.93);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        backdrop-filter: blur(4px);
    }

    .card-header {
        display: flex; justify-content: space-between; align-items: center;
    }

    .btn-tambah {
        background: #2A857D;
        padding: .5rem .9rem;
        border-radius: 6px;
        font-weight: bold;
        color: white;
        text-decoration: none;
    }

    /* TABLE */
    table { 
        width: 100%; 
        margin-top: 1rem; 
        border-collapse: collapse; 
    }

    th, td {
        padding: .8rem;
        border-bottom: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
    }

    th {
        background: #e5f3f3;
        font-weight: bold;
    }

    td:nth-child(5) {
        text-align: center;
        padding: 0 10px;
        white-space: nowrap;
    }

    .btn-edit, .btn-hapus {
        padding: .4rem .7rem;
        font-size: .85rem;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        color: white;
    }

    .btn-edit { background: #1f2937; }
    .btn-hapus { background: #dc3545; }
</style>

</head>

<body>

<!-- NAVBAR -->
<div class="topbar">
    <div class="nav">
        <div class="brand">HEALTH SYNC</div>

        <div class="nav-right">

            <div class="filter-dropdown">
                <button class="filter-btn">Filter ▼</button>
                <div class="filter-menu">
                    <button onclick="window.location='{{ route('admin.jadwal.home') }}'">Tampilkan Semua Data</button>
                    <button onclick="openFilter('id', 'Cari berdasarkan ID Jadwal', 'Masukkan ID Jadwal...')">ID Jadwal</button>
                    <button onclick="openFilter('lansia', 'Cari berdasarkan Nama Lansia', 'Masukkan nama lansia...')">Nama Lansia</button>
                    <button onclick="openFilter('tanggal', 'Cari berdasarkan Tanggal', 'Pilih tanggal...')">Tanggal</button>
                    <button onclick="openFilter('aktivitas', 'Cari berdasarkan Aktivitas', 'Masukkan aktivitas...')">Aktivitas</button>
                </div>
            </div>

            <a href="{{ route('admin.dashboard') }}">HOME</a>
        </div>
    </div>
</div>

<!-- POPUP FILTER -->
<div id="filter-popup" class="popup">
    <div class="popup-box">
        <h3 id="popup-title">Filter</h3>

        <form method="GET" action="{{ route('admin.jadwal.home') }}">
            <input type="hidden" name="filter" id="filter-type">
            <input type="text" id="filter-input" name="value" placeholder="Masukkan pencarian..." required>
            <button type="submit" class="popup-btn">Cari</button>
        </form>

        <button class="popup-close" onclick="closePopup()">Batal</button>
    </div>
</div>

<!-- POPUP KONFIRMASI -->
<div id="confirm-popup" class="popup">
    <div class="popup-box">
        <h3 id="confirm-title">Konfirmasi</h3>

        <button id="confirm-yes" class="popup-btn">Ya</button>
        <button onclick="closeConfirm()" class="popup-close">Tidak</button>
    </div>
</div>

<!-- POPUP SUKSES -->
<div id="success-popup" class="popup" style="display:none;">
    <div class="popup-box">
        <h3 id="success-title" style="margin-bottom:20px;">Berhasil!</h3>
        <button onclick="closeSuccess()" class="popup-btn">OK</button>
    </div>
</div>

<!-- CONTENT -->
<div class="wrap">
    <main class="content">

        <div class="card-overlay">

            <div class="card-header">
                <h2>Jadwal Kegiatan Lansia</h2>
                <a class="btn-tambah" href="{{ route('admin.jadwal.create') }}">Tambah</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 18%;">ID Jadwal</th>
                        <th style="width: 18%;">Lansia</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 15%;">Waktu</th>
                        <th style="width: 22%;">Aktivitas</th>
                        <th style="width: 12%;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($items as $item)
                <tr>
                    <td>{{ $item->id_jadwal }}</td>
                    <td>{{ $item->lansia->nama_lansia ?? '-' }}</td>
                    <td>{{ $item->tanggal?->format('d-m-Y') }}</td>
                    <td>{{ $item->waktu }}</td>
                    <td>{{ $item->aktivitas }}</td>

                    <td>
                        <button 
                            class="btn-edit"
                            onclick="confirmEdit('{{ route('admin.jadwal.edit', $item) }}')">
                            Edit
                        </button>

                        <form method="POST" 
                            action="{{ route('admin.jadwal.destroy', $item) }}"
                            style="display:inline;"
                            onsubmit="event.preventDefault(); confirmDelete(this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6">Belum ada data.</td></tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </main>
</div>

<script>
/* FILTER */
function openFilter(type, title, placeholder) {
    document.getElementById('filter-type').value = type;
    document.getElementById('popup-title').innerText = title;
    document.getElementById('filter-input').placeholder = placeholder;

    if (type === "tanggal") {
        document.getElementById('filter-input').type = "date";
    } else {
        document.getElementById('filter-input').type = "text";
    }

    document.getElementById('filter-popup').style.display = "flex";
}

function closePopup() {
    document.getElementById('filter-popup').style.display = "none";
}

/* KONFIRMASI */
let editUrl = "";
let deleteForm = null;

function confirmEdit(url) {
    editUrl = url;
    document.getElementById('confirm-title').innerText =
        "Apakah Anda ingin mengedit jadwal ini?";
    document.getElementById('confirm-popup').style.display = "flex";

    document.getElementById('confirm-yes').onclick = function () {
        window.location = editUrl;
    };
}

function confirmDelete(form) {
    deleteForm = form;
    document.getElementById('confirm-title').innerText =
        "Apakah Anda ingin menghapus jadwal ini?";
    document.getElementById('confirm-popup').style.display = "flex";

    document.getElementById('confirm-yes').onclick = function () {
        deleteForm.submit();
    };
}

function closeConfirm() {
    document.getElementById('confirm-popup').style.display = "none";
}

/* SUKSES */
function showSuccess(message) {
    document.getElementById('success-title').innerText = message;
    document.getElementById('success-popup').style.display = "flex";
}

function closeSuccess() {
    document.getElementById('success-popup').style.display = "none";
}
</script>

@if(session('success'))
<script>
window.onload = function() {
    showSuccess("{{ session('success') }}");
};
</script>
@endif

</body>
</html>

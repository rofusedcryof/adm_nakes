<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Instruksi Obat</title>

<style>
/* ===================== GLOBAL PAGE ===================== */
body { 
    margin: 0;
    padding: 1.5rem;
    font-family: system-ui, sans-serif;
    background: #f0f9f9;
}

/* ===================== NAVBAR ===================== */
.topbar {
    background: #2A857D;
    color: white;
    padding: 1.5rem 2.5rem;
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav a {
    color: white;
    font-weight: 700;
    text-decoration: none;
}

/* ===================== FILTER DROPDOWN ===================== */
.filter-dropdown {
    position: relative;
}

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
    background: white;
    min-width: 230px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    overflow: hidden;
    z-index: 30;
}

.filter-menu button {
    border: none;
    background: none;
    width: 100%;
    padding: .8rem 1rem;
    text-align: left;
    cursor: pointer;
    font-weight: 600;
    border-bottom: 1px solid #eee;
}

.filter-menu button:hover {
    background: #2A857D;
    color: white;
}

.filter-dropdown:hover .filter-menu {
    display: block;
}

/* ===================== POPUPS ===================== */
.popup {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.45);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 300;
}

.popup-box {
    background: white;
    width: 420px;
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0px 5px 25px rgba(0,0,0,.25);
}

.popup-box input {
    width: 100%;
    padding: 1rem;
    font-size: 1rem;
    margin-top: 1rem;
    border-radius: 10px;
    border: 1px solid #ccc;
}

.popup-btn {
    width: 100%;
    padding: .9rem;
    background: #2A857D;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    margin-top: 1rem;
    cursor: pointer;
}

.popup-close {
    width: 100%;
    padding: .9rem;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    margin-top: .6rem;
    cursor: pointer;
}

/* ===================== CONTENT ===================== */
.wrap {
    display: flex;
    justify-content: center;
}

/* ======= BACKGROUND LOGO (WATERMARK) ======= */
.content {
    position: relative;
    background: #2A857D;
    border-radius: 15px;
    padding: 2.5rem;
    width: 100%;
    min-height: calc(100vh - 150px);

    /* Tambahkan logo HEALTHSYNC */
    background-image: url('/images/HEALTHSYNC.png');
    background-repeat: no-repeat;
    background-position: center;
    background-size: 420px;  /* Sesuaikan ukuran */
}

.content-overlay {
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(3px);
    position: absolute;
    top: 30px;
    left: 30px;
    right: 30px;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,.2);
}

/* ===================== TABEL ===================== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

th, td {
    padding: .8rem;
    border-bottom: 1px solid #e5e7eb;
    font-size: .9rem;
    text-align: center !important;
    vertical-align: middle !important;
}

th {
    background: #e5f3f3;
    font-weight: 800;
}

tbody tr:hover {
    background: #f4fafa;
}

.badge {
    padding: .25rem .5rem;
    border-radius: 6px;
    font-size: .8rem;
    font-weight: 600;
}

.badge-aktif {
    background: #d1fae5;
    color: #065f46;
}

.badge-selesai {
    background: #fee2e2;
    color: #991b1b;
}

.btn-hapus {
    padding: .4rem .7rem;
    background: #dc2626;
    border-radius: 6px;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: .2s;
}

.btn-hapus:hover {
    background: #b91c1c;
}
</style>
</head>

<body>

<!-- ===================== NAV ===================== -->
<div class="topbar">
    <div class="nav">
        <div class="brand">HEALTH SYNC</div>

        <div class="nav-right">
            <!-- FILTER -->
            <div class="filter-dropdown">
                <button class="filter-btn">Filter ▼</button>

                <div class="filter-menu">
                    <button onclick="window.location='{{ route('admin.instruksi.index') }}'">Semua Data</button>
                    <button onclick="openFilter('lansia','Cari Nama Lansia','Masukkan nama lansia...')">Nama Lansia</button>
                    <button onclick="openFilter('obat','Cari Nama Obat','Masukkan nama obat...')">Nama Obat</button>
                    <button onclick="openFilter('status','Cari Status','Masukkan status...')">Status</button>
                    <button onclick="openFilter('medis','Cari Tenaga Medis','Masukkan tenaga medis...')">Medis</button>
                </div>
            </div>

            <a href="{{ route('admin.dashboard') }}">HOME</a>
        </div>
    </div>
</div>

<!-- ===================== POPUP FILTER ===================== -->
<div id="filter-popup" class="popup">
    <div class="popup-box">
        <h3 id="popup-title">Filter</h3>

        <form method="GET" action="{{ route('admin.instruksi.index') }}">
            <input type="hidden" id="filter-type" name="filter">
            <input type="text" id="filter-input" name="value" placeholder="Masukkan pencarian..." required>
            <button type="submit" class="popup-btn">Cari</button>
        </form>

        <button class="popup-close" onclick="closeFilter()">Batal</button>
    </div>
</div>

<!-- ===================== POPUP KONFIRMASI DELETE ===================== -->
<div id="confirm-popup" class="popup">
    <div class="popup-box">
        <h3>Apakah Anda ingin menghapus instruksi obat ini?</h3>
        <button id="confirm-yes" class="popup-btn">Ya</button>
        <button onclick="closeConfirm()" class="popup-close">Tidak</button>
    </div>
</div>

<!-- ===================== POPUP SUKSES ===================== -->
<div id="success-popup" class="popup">
    <div class="popup-box">
        <h3 id="success-title">Berhasil!</h3>
        <button onclick="closeSuccess()" class="popup-btn">OK</button>
    </div>
</div>

<!-- ===================== CONTENT ===================== -->
<div class="wrap">
<main class="content">

<div class="content-overlay">

    <h2>Instruksi Obat Lansia</h2>

    <table>
        <thead>
            <tr>
                <th>Lansia</th>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Frekuensi</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Status</th>
                <th>Medis</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($items as $it)
        <tr>
            <td>{{ $it->lansia->nama_lansia }}</td>
            <td><strong>{{ $it->nama_obat }}</strong></td>
            <td>{{ $it->dosis }}</td>
            <td>{{ $it->frekuensi }}</td>
            <td>{{ $it->mulai_pada?->format('d-m-Y') }}</td>
            <td>{{ $it->selesai_pada?->format('d-m-Y') }}</td>

            <td>
                <span class="badge {{ $it->status=='aktif'?'badge-aktif':'badge-selesai' }}">
                    {{ ucfirst($it->status) }}
                </span>
            </td>

            <td>{{ $it->medis->name }}</td>

            <td>
                <form method="POST"
                    action="{{ route('admin.instruksi.destroy',$it) }}"
                    onsubmit="event.preventDefault(); confirmDelete(this)">
                    @csrf
                    @method('DELETE')
                    <button class="btn-hapus">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    {{ $items->links() }}

</div>

</main>
</div>

<script>
function openFilter(type,title,placeholder){
    document.getElementById('filter-type').value = type;
    document.getElementById('popup-title').innerText = title;
    document.getElementById('filter-input').placeholder = placeholder;
    document.getElementById('filter-popup').style.display = "flex";
}

function closeFilter(){
    document.getElementById('filter-popup').style.display = "none";
}

let deleteForm = null;

function confirmDelete(form){
    deleteForm = form;
    document.getElementById('confirm-popup').style.display = "flex";

    document.getElementById('confirm-yes').onclick = function(){
        deleteForm.submit();
    };
}

function closeConfirm(){
    document.getElementById('confirm-popup').style.display = "none";
}

function showSuccess(message){
    document.getElementById('success-title').innerText = message;
    document.getElementById('success-popup').style.display = "flex";
}

function closeSuccess(){
    document.getElementById('success-popup').style.display = "none";
}
</script>

@if(session('ok'))
<script>
window.onload = function(){
    showSuccess("{{ session('ok') }}");
};
</script>
@endif

</body>
</html>

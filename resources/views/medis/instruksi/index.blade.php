<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Instruksi Obat</title>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial;
            background: #f0f9f9;
            padding: 1.5rem;
        }

        /* ================= TOPBAR ================= */
        .topbar {
            background: #2A857D;
            color: #fff;
            padding: 1.5rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 15px;
            margin-bottom: 1.8rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        }

        .brand {
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        .nav {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 2rem;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            margin-left: auto;
        }

        .nav-right a {
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
        }

        /* ================= FILTER DROPDOWN ================= */
        .filter-dropdown {
            position: relative;
            display: inline-block;
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
            background: #fff;
            min-width: 230px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            border-radius: 10px;
            overflow: hidden;
            z-index: 30;
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
            color: white;
        }

        /* ================= POPUPS ================= */
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
            padding: 2rem;
            width: 420px;
            border-radius: 12px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.25);
            text-align: center;
        }

        .popup-box input {
            width: 100%;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .popup-btn {
            width: 100%;
            margin-top: 1rem;
            padding: .9rem;
            background: #2A857D;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
        }

        .popup-close {
            width: 100%;
            margin-top: .6rem;
            padding: .9rem;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
        }

        /* ================= CONTENT GREEN WRAP ================= */
        .wrap {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .content {
            background: #2A857D;
            border-radius: 15px;
            padding: 2.5rem;
            width: 100%;
            min-height: calc(100vh - 180px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .logo-placeholder {
            max-width: 320px;
            width: 100%;
            opacity: 0.35;
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
        }

        .card-overlay {
            position: absolute;
            top: 30px;
            left: 30px;
            right: 30px;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.18);
            z-index: 10;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h2 {
            margin: 0;
            font-size: 1.7rem;
            font-weight: 900;
        }

        .btn-tambah {
            background: #2A857D;
            padding: .6rem .9rem;
            border-radius: 8px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            font-size: .9rem;
        }

        /* ================= TABLE ================= */
        .table-container {
            margin-top: 1.2rem;
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: .5rem;
        }

        th, td {
            padding: .8rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: .9rem;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background: #e5f3f3;
            font-weight: 800;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: .25rem .6rem;
            border-radius: 8px;
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

        .btn-edit,
        .btn-hapus {
            padding: .45rem .9rem;
            font-size: .85rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: white;
        }

        .btn-edit  { background: #1f2937; }
        .btn-hapus { background: #dc2626; }

        @media (max-width: 720px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: .8rem;
            }

            .btn-tambah {
                width: 100%;
                text-align: center;
            }

            .nav-right {
                gap: .7rem;
            }
        }
    </style>
</head>

<body>

    <!-- =============== TOPBAR =============== -->
    <div class="topbar">
        <div class="nav">
            <div class="brand">HEALTH SYNC</div>

            <div class="nav-right">

                <!-- FILTER DROPDOWN -->
                <div class="filter-dropdown">
                    <button class="filter-btn">Filter ▼</button>
                    <div class="filter-menu">
                        <button onclick="window.location='{{ route('medis.instruksi.index') }}'">
                            Semua Data
                        </button>
                        <button onclick="openFilter('lansia', 'Cari berdasarkan Nama Lansia', 'Masukkan nama lansia...')">
                            Nama Lansia
                        </button>
                        <button onclick="openFilter('obat', 'Cari berdasarkan Nama Obat', 'Masukkan nama obat...')">
                            Nama Obat
                        </button>
                        <button onclick="openFilter('status', 'Cari berdasarkan Status', 'Misal: aktif / selesai')">
                            Status
                        </button>
                        <button onclick="openFilter('mulai', 'Cari berdasarkan Tanggal Mulai', 'Pilih tanggal mulai...')">
                            Tanggal Mulai
                        </button>
                    </div>
                </div>

                <a href="#">NOTIFIKASI</a>

                <a href="{{ route('medis.dashboard') }}">HOME</a>
            </div>
        </div>
    </div>

    <!-- =============== POPUP FILTER =============== -->
    <div id="filter-popup" class="popup">
        <div class="popup-box">
            <h3 id="popup-title">Filter</h3>

            <form method="GET" action="{{ route('medis.instruksi.index') }}">
                <input type="hidden" name="filter" id="filter-type">
                <input type="text" name="value" id="filter-input" placeholder="Masukkan pencarian..." required>
                <button type="submit" class="popup-btn">Cari</button>
            </form>

            <button class="popup-close" onclick="closeFilter()">Batal</button>
        </div>
    </div>

    <!-- =============== POPUP KONFIRMASI HAPUS =============== -->
    <div id="confirm-popup" class="popup">
        <div class="popup-box">
            <h3>Apakah Anda ingin menghapus instruksi ini?</h3>
            <button id="confirm-yes" class="popup-btn">Ya</button>
            <button onclick="closeConfirm()" class="popup-close">Tidak</button>
        </div>
    </div>

    <!-- =============== POPUP SUKSES =============== -->
    <div id="success-popup" class="popup">
        <div class="popup-box">
            <h3 id="success-title">Berhasil!</h3>
            <button onclick="closeSuccess()" class="popup-btn">OK</button>
        </div>
    </div>

    <!-- =============== CONTENT =============== -->
    <div class="wrap">
        <main class="content">

            <img class="logo-placeholder" src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC">

            <div class="card-overlay">

                <div class="card-header">
                    <h2>Instruksi Obat Lansia</h2>
                    <a href="{{ route('medis.instruksi.create') }}" class="btn-tambah">Tambah Instruksi</a>
                </div>

                <div class="table-container">
                    @if ($items->isEmpty())
                        <p style="text-align:center; margin:2rem 0; color:#555;">
                            Belum ada instruksi obat.
                        </p>
                    @else
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
                            @foreach ($items as $i)
                                <tr>
                                    <td>{{ $i->lansia->nama_lansia }}</td>
                                    <td><strong>{{ $i->nama_obat }}</strong></td>
                                    <td>{{ $i->dosis ?? '-' }}</td>
                                    <td>{{ $i->frekuensi ?? '-' }}</td>
                                    <td>{{ $i->mulai_pada?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $i->selesai_pada?->format('d-m-Y') ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $i->status === 'aktif' ? 'badge-aktif' : 'badge-selesai' }}">
                                            {{ ucfirst($i->status ?? '-') }}
                                        </span>
                                    </td>
                                    <td>{{ $i->medis->name ?? '-' }}</td>
                                    <td>
                                        <button
                                            class="btn-edit"
                                            onclick="window.location='{{ route('medis.instruksi.edit', $i) }}'">
                                            Edit
                                        </button>

                                        <form method="POST"
                                              action="{{ route('medis.instruksi.destroy', $i) }}"
                                              style="display:inline;"
                                              onsubmit="event.preventDefault(); confirmDelete(this);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-hapus">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="margin-top:1rem;">
                        {{ $items->links() }}
                    </div>

                    @endif
                </div>

            </div>

        </main>
    </div>

    <!-- =============== JAVASCRIPT =============== -->
    <script>
        /* ========== FILTER POPUP ========== */
        function openFilter(type, title, placeholder) {
            document.getElementById('filter-type').value = type;
            document.getElementById('popup-title').innerText = title;
            const input = document.getElementById('filter-input');

            if (type === 'mulai') {
                input.type = 'date';
            } else {
                input.type = 'text';
            }
            input.placeholder = placeholder;

            document.getElementById('filter-popup').style.display = 'flex';
        }

        function closeFilter() {
            document.getElementById('filter-popup').style.display = 'none';
        }

        /* ========== KONFIRMASI HAPUS ========== */
        let deleteForm = null;

        function confirmDelete(form) {
            deleteForm = form;
            document.getElementById('confirm-popup').style.display = 'flex';
            document.getElementById('confirm-yes').onclick = function () {
                deleteForm.submit();
            };
        }

        function closeConfirm() {
            document.getElementById('confirm-popup').style.display = 'none';
        }

        /* ========== SUCCESS POPUP ========== */
        function showSuccess(message) {
            document.getElementById('success-title').innerText = message;
            document.getElementById('success-popup').style.display = 'flex';
        }

        function closeSuccess() {
            document.getElementById('success-popup').style.display = 'none';
        }
    </script>

    @if(session('ok'))
    <script>
        window.onload = function () {
            showSuccess("{{ session('ok') }}");
        };
    </script>
    @endif

</body>
</html>

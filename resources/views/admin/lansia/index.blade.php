<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Data Lansia</title>

    <style>
    /* GLOBAL */
    body{
        margin:0;
        padding:1.5rem;
        font-family:system-ui, sans-serif;
        background:#f0f9f9;
    }

    /* TOPBAR */
    .topbar{
        background:#2A857D;
        color:white;
        padding:1.3rem 2rem;
        border-radius:15px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        box-shadow:0 3px 8px rgba(0,0,0,0.1);
    }

    .brand{
        font-size:1.4rem;
        font-weight:900;
    }

    /* NEW NAV STYLE */
    .nav-link{
        color:white;
        font-weight:700;
        text-decoration:none;
        padding:0 .3rem;
    }

    .nav-link:hover{
        text-decoration:underline;
    }

    /* WRAPPER */
    .wrap{
        width:100%;
        display:flex;
        justify-content:center;
        margin-top:2rem;
    }

    /* CONTENT */
    .content{
        background:#2A857D;
        border-radius:15px;
        padding:3rem;
        width:100%;
        min-height:calc(100vh - 150px);

        background-image:url('/images/HEALTHSYNC.png');
        background-repeat:no-repeat;
        background-position:center;
        background-size:420px;

        display:flex;
        justify-content:center;
    }

    /* CARD */
    .card{
        background:white;
        width:100%;
        max-width:1150px;
        padding:2rem;
        border-radius:18px;
        box-shadow:0 4px 12px rgba(0,0,0,0.15);
    }

    /* TABLE */
    table{
        width:100%;
        margin-top:1rem;
        border-collapse:collapse;
        border-radius:12px;
        overflow:hidden;
    }

    th,td{
        padding:.85rem;
        border-bottom:1px solid #e5e7eb;
        text-align:center;
        font-size:.9rem;
    }

    th{
        background:#e5f3f3;
        font-weight:800;
    }

    tbody tr:hover{
        background:#f4fafb;
    }

    /* ALERT */
    .alert{
        background:#e9fff1;
        color:#0f5132;
        padding:10px;
        border-radius:8px;
        margin-bottom:1rem;
        font-weight:600;
    }
    </style>

</head>
<body>

<!-- NAV -->
<div class="topbar">
    <div class="brand">HEALTH SYNC</div>

    <div>
        <a href="{{ route('admin.lansia.create') }}" class="nav-link">
            Tambah Lansia
        </a>

        <a href="{{ route('admin.dashboard') }}" class="nav-link" style="margin-left:1rem;">
            Home
        </a>
    </div>
</div>

<!-- CONTENT -->
<div class="wrap">
    <main class="content">

        <div class="card">

            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <h2 style="margin-bottom:1rem;">Daftar Lansia</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID Lansia</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Keluarga</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $l)
                    <tr>
                        <td>{{ $l->id_lansia }}</td>
                        <td>{{ $l->nama_lansia }}</td>
                        <td>{{ $l->alamat }}</td>
                        <td>
                            @php $kel = $l->keluarga->first(); @endphp
                            {{ $kel?->nama }} ({{ $kel?->email }})
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top:15px;">
                {{ $items->links() }}
            </div>

        </div>

    </main>
</div>

</body>
</html>

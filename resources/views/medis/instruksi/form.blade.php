<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode==='create' ? 'Tambah' : 'Edit' }} Instruksi Obat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1f8a8a;
            --secondary: #247e81;
            --dark: #0f172a;
            --light: #ffffff;
            --gray: #f3f4f6;
        }

        body {
            margin: 0;
            background: var(--gray);
            font-family: 'Inter', sans-serif;
        }

        /* ---------- TOPBAR ---------- */
        .topbar {
            background: var(--primary);
            color: var(--light);
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid var(--dark);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        .brand {
            display: flex;
            align-items: center;
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }
        .brand svg {
            margin-right: 10px;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .nav a {
            font-weight: 700;
            color: var(--light);
            text-decoration: none;
            border-radius: 9999px;
            padding: 0.4rem 0.8rem;
            transition: background-color 0.2s;
        }
        .nav a:hover {
            background: rgba(255,255,255,0.15);
        }

        .logout {
            background: var(--dark);
            color: var(--light);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }
        .logout:hover {
            background: #334155;
        }

        /* ---------- WRAPPER ---------- */
        .wrap {
            display: flex;
            min-height: calc(100vh - 64px);
        }

        /* ---------- SIDEBAR ---------- */
        .sidebar {
            width: 260px;
            background: var(--secondary);
            padding: 2rem 1rem;
            border-right: 4px solid var(--dark);
            box-shadow: 4px 0 8px rgba(0,0,0,0.1);
        }

        .side-btn {
            display: block;
            width: 100%;
            background: var(--secondary);
            color: var(--light);
            padding: 0.9rem 1.2rem;
            border-radius: 10px;
            font-weight: 800;
            text-align: left;
            text-decoration: none;
            border: 3px solid var(--dark);
            box-shadow: 0 4px 0 var(--dark);
            transition: all 0.2s;
        }

        .side-btn:hover {
            background: #1a6669;
            transform: translateY(-2px);
        }

        .side-btn.active {
            background: var(--primary);
            transform: translateY(4px);
            box-shadow: none;
        }

        /* ---------- MAIN CONTENT ---------- */
        .content {
            flex: 1;
            padding: 3rem 2rem;
            display: flex;
            justify-content: center;
        }

        .form-wrap {
            background: var(--light);
            border: 2px solid var(--dark);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 720px;
            box-shadow: 0 6px 10px rgba(0,0,0,0.15);
        }

        .form-wrap h2 {
            font-size: 1.75rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            color: var(--dark);
            border-bottom: 3px dashed #e5e7eb;
            padding-bottom: 0.75rem;
            text-align: center;
        }

        label {
            font-weight: 700;
            display: block;
            margin-top: 1rem;
            margin-bottom: 0.4rem;
            color: var(--dark);
        }

        select, input, textarea {
            width: 100%;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            padding: 0.7rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        select:focus, input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(31,138,138,0.2);
        }

        .row {
            display: flex;
            gap: 1.5rem;
        }
        .row > div {
            flex: 1;
        }

        .actions {
            margin-top: 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn {
            background: var(--secondary);
            color: var(--light);
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            border: 2px solid var(--dark);
            box-shadow: 0 3px 0 var(--dark);
            font-weight: 700;
            transition: all 0.15s;
        }
        .btn:hover {
            background: #1a6669;
            transform: translateY(-2px);
        }

        .btn.cancel {
            background: #6b7280;
        }
        .btn.cancel:hover {
            background: #4b5563;
        }

        .error-message {
            background: #fee2e2;
            border: 1px solid #dc2626;
            padding: 1rem;
            border-radius: 8px;
            color: #b91c1c;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .wrap {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 4px solid var(--dark);
            }
            .content {
                padding: 1.5rem;
            }
            .row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="brand">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path d="M12 2v20M4 12h16M6 6h12M6 18h12"/>
            </svg>
            HEALTH SYNC
        </div>
        <div class="nav">
            <a href="{{ route('medis.dashboard') }}">HOME</a>
            <a href="#">NOTIFIKASI</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout" type="submit">Keluar</button>
            </form>
        </div>
    </div>

    <div class="wrap">
        <aside class="sidebar">
            <a class="side-btn" href="{{ route('medis.riwayat') }}">Riwayat Kondisi Lansia</a>
            <a class="side-btn active" href="{{ route('medis.instruksi.index') }}">Instruksi Obat</a>
        </aside>

        <main class="content">
            <div class="form-wrap">
                <h2>{{ $mode==='create' ? 'Tambah' : 'Edit' }} Instruksi Obat</h2>

                @if ($errors->any())
                    <div class="error-message">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ $mode==='create' ? route('medis.instruksi.store') : route('medis.instruksi.update', $item->id ?? $item) }}">
                    @csrf
                    @if($mode==='edit') @method('PUT') @endif

                    <label for="lansia_id">Lansia <span class="text-red-600">*</span></label>
                    <select id="lansia_id" name="lansia_id" required>
                        <option value="">-- Pilih Lansia --</option>
                        @foreach ($lansia as $l)
                            <option value="{{ $l->id }}" @selected(old('lansia_id', $item->lansia_id ?? null) == $l->id)>
                                {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                            </option>
                        @endforeach
                    </select>

                    <label for="nama_obat">Nama Obat <span class="text-red-600">*</span></label>
                    <input id="nama_obat" type="text" name="nama_obat" value="{{ old('nama_obat', $item->nama_obat ?? '') }}" required placeholder="Contoh: Amlodipine, Paracetamol, dll">

                    <div class="row">
                        <div>
                            <label for="dosis">Dosis</label>
                            <input id="dosis" type="text" name="dosis" value="{{ old('dosis', $item->dosis ?? '') }}" placeholder="Contoh: 5mg, 500mg, dll">
                        </div>
                        <div>
                            <label for="frekuensi">Frekuensi</label>
                            <input id="frekuensi" type="text" name="frekuensi" value="{{ old('frekuensi', $item->frekuensi ?? '') }}" placeholder="Contoh: 1x sehari, 3x sehari, dll">
                        </div>
                    </div>

                    <div class="row">
                        <div>
                            <label for="mulai_pada">Mulai Pada</label>
                            <input id="mulai_pada" type="date" name="mulai_pada" value="{{ old('mulai_pada', optional($item->mulai_pada ?? null)->format('Y-m-d')) }}">
                        </div>
                        <div>
                            <label for="selesai_pada">Selesai Pada</label>
                            <input id="selesai_pada" type="date" name="selesai_pada" value="{{ old('selesai_pada', optional($item->selesai_pada ?? null)->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <label for="status">Status</label>
                    <select id="status" name="status">
                        @foreach (['aktif','selesai','ditunda'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $item->status ?? 'aktif') == $s)>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>

                    <label for="catatan">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" placeholder="Catatan tambahan tentang instruksi obat...">{{ old('catatan', $item->catatan ?? '') }}</textarea>

                    <div class="actions">
                        <button class="btn" type="submit">Simpan</button>
                        <a class="btn cancel" href="{{ route('medis.instruksi.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

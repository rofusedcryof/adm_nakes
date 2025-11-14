<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HEALTH SYNC - Instruksi Obat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #1f8a8a;
      --secondary: #166969;
      --dark: #0f172a;
      --light: #ffffff;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #e6f4f1, #d4efec);
      min-height: 100vh;
      color: var(--dark);
      overflow-x: hidden;
    }

    /* ===== Topbar (SAMA DENGAN DASHBOARD) ===== */
        .topbar {
            background: linear-gradient(90deg, var(--primary), #0e4d4d);
            color: var(--light);
            padding: .8rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        .brand {
            display: flex;
            align-items: center;
            font-weight: 900;
            font-size: 1.6rem;
            letter-spacing: 1px;
        }

        .brand svg {
            margin-right: 10px;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav a {
            font-weight: 700;
            transition: 0.25s;
            padding: .5rem 1rem;
            border-radius: 9999px;
        }

        .nav a:hover {
            background: rgba(255,255,255,0.15);
        }

        .nav button {
            background: #0f172a;
            color: #fff;
            font-weight: 800;
            border: none;
            border-radius: 9999px;
            padding: .5rem 1.2rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .nav button:hover {
            background: #334155;
        }

    /* ===== Layout ===== */
    .wrap {
      display: flex;
      min-height: calc(100vh - 64px);
    }

    /* ===== Sidebar (SAMA DENGAN DASHBOARD) ===== */
    .sidebar {
      width: 270px;
      background: var(--secondary);
      padding: 1.8rem 1.2rem;
      display: flex;
      flex-direction: column;
      box-shadow: 4px 0 10px rgba(0,0,0,0.15);
    }

    .side-btn {
      display: block;
      background: transparent;
      color: #e5f8f8;
      padding: .8rem 1rem;
      border-radius: 10px;
      font-weight: 700;
      margin-bottom: 1rem;
      text-decoration: none;
      border: 2px solid transparent;
      transition: 0.25s;
    }

    .side-btn:hover {
      background: rgba(255,255,255,0.15);
      border-color: rgba(255,255,255,0.3);
    }

    .side-btn.active {
      background: var(--primary);
      color: #fff;
      border-color: #0f172a;
    }

    /* ===== Content ===== */
    .content {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 2rem 0;
}

.panel {
  background: #fff;
  border-radius: 16px;
  padding: 1.5rem 2rem;
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
  border: 1px solid rgba(0,0,0,0.05);
  width: 100%;
  max-width: 900px; /* 👉 ubah ini untuk mengatur lebar tabel */
  margin: 0 auto;
}

    .title {
      font-weight: 900;
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
      color: var(--secondary);
      border-bottom: 3px solid #d1e7e5;
      padding-bottom: .5rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }

    th, td {
      padding: .50rem 1rem;
      border-bottom: 1px solid #e5e7eb;
      text-align: left;
      vertical-align: middle;
    }

    th {
      background: #a8dadc;
      color: var(--dark);
      font-weight: 900;
      text-transform: uppercase;
      font-size: .9rem;
    }

    tr:nth-child(even) {
      background: #f1f9f9;
    }

    .add-btn {
      background: var(--primary);
      color: white;
      padding: .5rem .8rem;
      border-radius: 8px;
      font-weight: 700;
      text-decoration: none;
      transition: .2s;
    }

    .add-btn:hover {
      background: var(--secondary);
    }

    .badge {
      padding: .3rem .6rem;
      border-radius: 9999px;
      font-size: .75rem;
      font-weight: 700;
    }

    .badge-aktif {
      background: #d1fae5;
      color: #065f46;
    }

    .badge-selesai {
      background: #fee2e2;
      color: #991b1b;
    }

    .action-group {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
    }

    .action-btn {
      background: var(--dark);
      color: #fff;
      padding: .45rem .9rem;
      border-radius: 6px;
      font-size: .85rem;
      text-decoration: none;
      font-weight: 600;
      transition: 0.2s;
      display: inline-flex;
      align-items: center;
      gap: .3rem;
    }

    .action-btn.edit {
      background: var(--primary);
    }

    .action-btn.delete {
      background: #dc2626;
    }

    .action-btn:hover {
      opacity: 0.9;
      transform: scale(1.03);
    }

    @media (max-width: 768px) {
      .wrap { flex-direction: column; }
      .sidebar {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        padding: 1rem;
      }
      .content { padding: 1rem; }
    }
  </style>
</head>
<body>
  <div class="topbar">
    <div class="brand">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="3" width="28" height="28" viewBox="0 0 24 24">
        <path d="M12 2v20M4 12h16"></path>
      </svg>
      HEALTH SYNC
    </div>

    <div class="nav">
      <a href="{{ route('medis.dashboard') }}" class="bg-white/20">Home</a>
      <a href="#">Notifikasi</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Keluar</button>
      </form>
    </div>
  </div>

  <div class="wrap">
    <aside class="sidebar">
      <a href="{{ route('medis.riwayat') }}" class="side-btn">Riwayat Kondisi Lansia</a>
      <a href="{{ route('medis.instruksi.index') }}" class="side-btn active">Instruksi Obat</a>
    </aside>

    <main class="content">
      <div class="panel">
        <div class="title">Instruksi Obat</div>

        <div class="flex justify-between items-center mb-4">
          <h2 class="font-semibold text-lg">Daftar Instruksi</h2>
          <a href="{{ route('medis.instruksi.create') }}" class="add-btn">+ Tambah Instruksi</a>
        </div>

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
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Bapak Budi</td>
              <td><strong>Paracetamol</strong></td>
              <td>500 mg</td>
              <td>3x Sehari</td>
              <td>01-11-2025</td>
              <td>08-11-2025</td>
              <td><span class="badge badge-aktif">Aktif</span></td>
              <td>Dr. Angga</td>
              <td>
                <div class="action-group">
                  <a href="#" class="action-btn edit">Edit</a>
                  <a href="#" class="action-btn delete">Hapus</a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>

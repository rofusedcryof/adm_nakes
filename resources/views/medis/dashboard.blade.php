<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HEALTH SYNC - Dashboard Tenaga Medis</title>
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

    /* ===== Topbar ===== */
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
      padding: 2rem 3rem;
      background: rgba(255,255,255,0.6);
      backdrop-filter: blur(8px);
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo-container {
      text-align: center;
      color: var(--dark);
      opacity: 0.9;
      z-index: 2;
      position: relative;
    }

    .logo-container img {
      max-width: 350px;
      margin-bottom: 20px;
      filter: brightness(1.1);
    }

    .logo-text {
      font-size: 2.8rem;
      font-weight: 900;
      letter-spacing: 2px;
    }

    .logo-subtext {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--secondary);
    }

    /* ===== Background Logo ===== */
    .logo-bg {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.08;
      z-index: 1;
      text-align: center;
      pointer-events: none;
    }

    .logo-bg svg {
      width: 240px;
      height: 240px;
      fill: var(--primary);
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
      .wrap {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        padding: 1rem;
      }
      .content {
        padding: 1.5rem;
      }
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
      <a href="{{ route('medis.instruksi.index') }}" class="side-btn">Instruksi Obat</a>
    </aside>

    <main class="content">
      <div style="width: 100%; max-width: 1200px;">
        <!-- Statistik Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
          <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 0.5rem;">Total Lansia</div>
            <div style="font-size: 2rem; font-weight: 900; color: var(--primary);">{{ $totalLansia }}</div>
          </div>
          <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 0.5rem;">Notifikasi</div>
            <div style="font-size: 2rem; font-weight: 900; color: #ef4444;">{{ $totalNotifikasi }}</div>
          </div>
          <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 0.5rem;">Instruksi Aktif</div>
            <div style="font-size: 2rem; font-weight: 900; color: #10b981;">{{ $totalInstruksiAktif }}</div>
          </div>
        </div>

        <!-- Notifikasi Darurat -->
        @if($notifikasiDarurat->count() > 0)
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
          <h2 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 1rem; color: var(--dark);">🚨 Notifikasi Darurat</h2>
          <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($notifikasiDarurat as $notif)
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 1rem; border-radius: 8px;">
              <div style="font-weight: 700; color: #dc2626; margin-bottom: 0.5rem;">{{ $notif->pesan }}</div>
              <div style="font-size: 0.85rem; color: #64748b;">{{ $notif->created_at->format('d/m/Y H:i') }}</div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        <!-- Kondisi Darurat -->
        @if($kondisiDarurat->count() > 0)
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
          <h2 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 1rem; color: var(--dark);">⚠️ Kondisi Darurat</h2>
          <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($kondisiDarurat as $kondisi)
            <div style="background: #fff7ed; border-left: 4px solid #f59e0b; padding: 1rem; border-radius: 8px;">
              <div style="font-weight: 700; color: #d97706; margin-bottom: 0.5rem;">
                {{ $kondisi->lansia->nama_lansia }} - {{ $kondisi->diukur_pada->format('d/m/Y H:i') }}
              </div>
              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 0.5rem; font-size: 0.9rem;">
                @if($kondisi->sistol) <div>TD: {{ $kondisi->sistol }}/{{ $kondisi->diastol }}</div> @endif
                @if($kondisi->nadi) <div>Nadi: {{ $kondisi->nadi }} bpm</div> @endif
                @if($kondisi->suhu) <div>Suhu: {{ $kondisi->suhu }}°C</div> @endif
                @if($kondisi->gula_darah) <div>Gula: {{ $kondisi->gula_darah }} mg/dL</div> @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        <!-- Lansia yang Di-handle -->
        @if($lansia->count() > 0)
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
          <h2 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 1rem; color: var(--dark);">👥 Lansia yang Di-handle</h2>
          <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
            @foreach($lansia as $l)
            <div style="background: #f0fdf4; padding: 1rem; border-radius: 8px; border: 2px solid #86efac;">
              <div style="font-weight: 700; color: var(--primary); margin-bottom: 0.25rem;">{{ $l->nama_lansia }}</div>
              <div style="font-size: 0.85rem; color: #64748b;">ID: {{ $l->id_lansia }}</div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        <!-- Instruksi Obat Aktif -->
        @if($instruksiAktif->count() > 0)
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
          <h2 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 1rem; color: var(--dark);">💊 Instruksi Obat Aktif</h2>
          <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($instruksiAktif as $instruksi)
            <div style="background: #f0f9ff; border-left: 4px solid #0ea5e9; padding: 1rem; border-radius: 8px;">
              <div style="font-weight: 700; color: #0284c7; margin-bottom: 0.5rem;">
                {{ $instruksi->lansia->nama_lansia }} - {{ $instruksi->nama_obat }}
              </div>
              <div style="font-size: 0.9rem; color: #64748b;">
                Dosis: {{ $instruksi->dosis }} | Frekuensi: {{ $instruksi->frekuensi }}
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        <!-- Empty State -->
        @if($lansia->count() == 0 && $notifikasiDarurat->count() == 0 && $kondisiDarurat->count() == 0)
        <div style="text-align: center; padding: 3rem;">
          <div class="logo-container">
            <img src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC Logo">
          </div>
          <p style="color: #64748b; margin-top: 1rem;">Belum ada data untuk ditampilkan</p>
        </div>
        @endif
      </div>
    </main>
  </div>
</body>
</html>

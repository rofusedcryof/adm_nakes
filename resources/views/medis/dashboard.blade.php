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
      <div class="logo-bg">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
      </div>

      <div class="logo-container">
        <img src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC Logo">
      </div>
    </main>
  </div>
</body>
</html>

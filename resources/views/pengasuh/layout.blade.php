<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC</title>

<style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:Arial, sans-serif; }

    body {
        background:#1E7F77;
        min-height:100vh;
        padding-bottom:110px;
        display:flex;
        justify-content:center;
        position:relative;
    }

    /* LOGO WATERMARK */
    body::before {
        content:"";
        position:absolute;
        top:50%; left:50%;
        width:260px; height:260px;
        transform:translate(-50%, -50%);
        background:url('/images/HEALTHSYNC.png') no-repeat center;
        background-size:230px;
        opacity:0.12;
        z-index:0;
    }

    .phone { width:360px; max-width:100%; min-height:100vh; z-index:10; position:relative; }

    .topbar {
        background:#2A857D;
        color:white;
        padding:16px;
        text-align:center;
        font-weight:800;
        font-size:17px;
    }

    .container { padding:16px; padding-bottom:130px; }

    /* NAV BAWAH */
    .bottom-nav {
        position:fixed;
        bottom:0; left:50%;
        transform:translateX(-50%);
        width:360px;
        background:#2A857D;
        padding:6px 10px;
        z-index:20;
    }

    .nav-inner {
        background:white;
        border-radius:14px;
        display:flex;
        overflow:hidden;
        box-shadow:0 -4px 10px rgba(0,0,0,0.18);
    }

    .nav-item {
        flex:1;
        text-align:center;
        padding:10px 0;
        font-size:0.78rem;
        color:black;
        text-decoration:none;
        border-right:1px solid #eee;
    }

    .nav-item:last-child { border-right:none; }
    .nav-item.active { color:#2A857D; font-weight:bold; }

    .nav-icon {
        width:22px; height:22px;
        margin-bottom:2px;
        background-size:contain;
        background-repeat:no-repeat;
        display:inline-block;
    }

    .icon-home {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%232A857D' fill='none' viewBox='0 0 24 24'%3E%3Cpath d='M3 12l9-9 9 9' stroke-width='2'/%3E%3Cpath d='M9 21V12h6v9' stroke-width='2'/%3E%3C/svg%3E");
    }
    .icon-bell {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%23000000' fill='none' viewBox='0 0 24 24'%3E%3Cpath d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/%3E%3C/svg%3E");
    }
    .icon-profile {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23000000' viewBox='0 0 24 24'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E");
    }
</style>

</head>

<body>

<div class="phone">
    <div class="topbar">HEALTH SYNC</div>

    <div class="container">
        @yield('content')
    </div>
</div>

<!-- BOTTOM NAV -->
<div class="bottom-nav">
    <div class="nav-inner">
        <a href="{{ route('pengasuh.dashboard') }}"
           class="nav-item {{ request()->routeIs('pengasuh.dashboard') ? 'active' : '' }}">
            <span class="nav-icon icon-home"></span><br>Home
        </a>

        <a href="{{ route('pengasuh.notifikasi') }}"
           class="nav-item {{ request()->routeIs('pengasuh.notifikasi') ? 'active' : '' }}">
            <span class="nav-icon icon-bell"></span><br>Notifikasi
        </a>

        <a href="{{ route('pengasuh.profil') }}"
           class="nav-item {{ request()->routeIs('pengasuh.profil') ? 'active' : '' }}">
            <span class="nav-icon icon-profile"></span><br>Profil
        </a>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>HEALTH SYNC - Pengasuh</title>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #E5E5E5;
            min-height: 100vh;
            margin: 0;
            padding-bottom: 90px;
        }

        .topbar {
            background: #2A857D;
            padding: 16px;
            color: white;
            font-weight: 700;
            text-align: center;
        }

        .wrapper {
            max-width: 380px;
            margin: auto;
            padding: 14px;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 380px;
            max-width: 100%;
            background: #2A857D;
            padding: 6px 10px;
            z-index: 50;
        }

        .nav-inner {
            background: white;
            border-radius: 14px;
            display: flex;
            overflow: hidden;
        }

        .nav-item {
            flex: 1;
            padding: 10px 0;
            text-align: center;
            text-decoration: none;
            color: black;
            font-size: .8rem;
            border-right: 1px solid #eee;
        }

        .nav-item:last-child { border-right: none; }

        .nav-item.active {
            color: #2A857D;
            font-weight: 700;
        }

        .nav-icon {
            width: 22px;
            height: 22px;
            margin-bottom: 3px;
            background-size: contain;
            background-repeat: no-repeat;
            display: inline-block;
        }

        .icon-home {
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%232A857D' fill='none' viewBox='0 0 24 24'%3E%3Cpath d='M3 12l9-9 9 9' stroke-width='2'/%3E%3Cpath d='M9 21V12h6v9' stroke-width='2'/%3E%3C/svg%3E");
        }
        .icon-bell {
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%23000000' fill='none' viewBox='0 0 24 24'%3E%3Cpath d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/%3E%3C/svg%3E");
        }
        .icon-user {
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23000000' viewBox='0 0 24 24'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E");
        }
    </style>
</head>

<body>

    <div class="topbar">HEALTH SYNC</div>

    {{-- HALAMAN YANG FULL HIJAU --}}
    @if(
        request()->routeIs('pengasuh.dashboard') ||
        request()->routeIs('pengasuh.riwayat') ||
        request()->routeIs('pengasuh.notifikasi') || 
        request()->routeIs('pengasuh.profil') || 
        request()->routeIs('pengasuh.kegiatan-lansia.*')
    )
        @yield('content')
    @else
        {{-- HALAMAN PUTIH BIASA --}}
        <div class="wrapper">
            @yield('content')
        </div>
    @endif

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
               <span class="nav-icon icon-user"></span><br>Profil
            </a>

        </div>
    </div>

</body>
</html>

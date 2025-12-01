<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>HEALTH SYNC - Notifikasi</title>
    <style>
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;background:#E5E5E5;min-height:100vh;padding-bottom:80px;margin:0}
        .header{background:#2A857D;color:#fff;padding:1rem;text-align:center;font-weight:bold;letter-spacing:1px}
        .container{padding:1rem}
        .item{background:#fff;border-radius:12px;padding:0.75rem 1rem;margin-bottom:0.6rem;box-shadow:0 1px 3px rgba(0,0,0,0.1)}
        .item-title{font-weight:600;color:#111827}
        .item-meta{font-size:0.8rem;color:#6B7280}
        .bottom-nav{position:fixed;bottom:0;left:0;right:0;background:#fff;display:flex;justify-content:space-around;align-items:center;padding:0.75rem 0;box-shadow:0 -2px 8px rgba(0,0,0,0.1)}
        .nav-item{display:flex;flex-direction:column;align-items:center;text-decoration:none;color:#000;flex:1}
        .nav-item.active{color:#2A857D}
        .nav-icon{width:24px;height:24px;margin-bottom:0.25rem}
        .icon-home{display:inline-block;width:24px;height:24px;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232A857D'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'/%3E%3C/svg%3E");background-size:contain}
        .icon-bell{display:inline-block;width:24px;height:24px;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/%3E%3C/svg%3E");background-size:contain}
        .icon-profile{display:inline-block;width:24px;height:24px;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23000'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E");background-size:contain}
    </style>
</head>
<body>
    <div class="header">HEALTH SYNC</div>
    <div class="container">
        @forelse($items as $n)
            <div class="item">
                <div class="item-title">{{ $n->pesan }}</div>
                <div class="item-meta">{{ $n->tipe }} • {{ optional($n->created_at)->format('d/m/Y H:i') }}</div>
            </div>
        @empty
            <div class="item">Tidak ada notifikasi.</div>
        @endforelse
    </div>

    <div class="bottom-nav">
        <a href="{{ route('pengasuh.dashboard') }}" class="nav-item">
            <span class="icon-home nav-icon"></span>
            <span style="font-size:12px;">Home</span>
        </a>
        <a href="{{ route('pengasuh.notifikasi') }}" class="nav-item active">
            <span class="icon-bell nav-icon"></span>
            <span style="font-size:12px;">Notifikasi</span>
        </a>
        <a href="{{ route('pengasuh.profil') }}" class="nav-item">
            <span class="icon-profile nav-icon"></span>
            <span style="font-size:12px;">Profil</span>
        </a>
    </div>
</body>
</html>

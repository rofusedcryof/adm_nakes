<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>HEALTH SYNC - Update Kondisi Lansia</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #E5E5E5;
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .header {
            background-color: #2A857D;
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            letter-spacing: 1px;
            position: relative;
        }

        .back-btn {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .container {
            padding: 1rem;
        }

        .form-card {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #000;
            font-size: 0.95rem;
        }

        label .required {
            color: #D32F2F;
        }

        select, input, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 1rem;
            background-color: white;
            font-family: inherit;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #2A857D;
            box-shadow: 0 0 0 3px rgba(42, 133, 125, 0.1);
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background-color: #2A857D;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .alert-error {
            background-color: #FEE2E2;
            color: #991B1B;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .alert-error ul {
            margin-left: 1.25rem;
            margin-top: 0.5rem;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0.75rem 0;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #000;
            flex: 1;
        }

        .nav-item.active {
            color: #2A857D;
        }

        .nav-icon {
            width: 24px;
            height: 24px;
            margin-bottom: 0.25rem;
        }

        .icon-home {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232A857D'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'/%3E%3C/svg%3E");
            background-size: contain;
        }

        .icon-bell {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/%3E%3C/svg%3E");
            background-size: contain;
        }

        .icon-profile {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23000'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E");
            background-size: contain;
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-btn" onclick="window.location.href='{{ route('pengasuh.dashboard') }}'">←</button>
        UPDATE KONDISI LANSIA
    </div>

    <div class="container">
        @if($errors->any())
            <div class="alert-error">
                <strong>Terjadi Kesalahan!</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pengasuh.update-kondisi.store') }}" class="form-card">
            @csrf

            <div class="form-group">
                <label for="lansia_id">Lansia <span class="required">*</span></label>
                <select name="lansia_id" id="lansia_id" required>
                    <option value="">-- Pilih Lansia --</option>
                    @foreach($lansia as $l)
                        <option value="{{ $l->id }}" {{ old('lansia_id') == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="diukur_pada">Tanggal & Waktu Pengukuran <span class="required">*</span></label>
                <input type="datetime-local" name="diukur_pada" id="diukur_pada" 
                       value="{{ old('diukur_pada', now()->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="sistol">Sistol (mmHg)</label>
                    <input type="number" name="sistol" id="sistol" 
                           value="{{ old('sistol') }}" min="0" max="300" placeholder="120">
                </div>
                <div class="form-group">
                    <label for="diastol">Diastol (mmHg)</label>
                    <input type="number" name="diastol" id="diastol" 
                           value="{{ old('diastol') }}" min="0" max="200" placeholder="80">
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="nadi">Nadi (bpm)</label>
                    <input type="number" name="nadi" id="nadi" 
                           value="{{ old('nadi') }}" min="0" max="200" placeholder="72">
                </div>
                <div class="form-group">
                    <label for="suhu">Suhu (°C)</label>
                    <input type="number" name="suhu" id="suhu" step="0.1"
                           value="{{ old('suhu') }}" min="30" max="45" placeholder="36.5">
                </div>
            </div>

            <div class="form-group">
                <label for="gula_darah">Gula Darah (mg/dL)</label>
                <input type="number" name="gula_darah" id="gula_darah" 
                       value="{{ old('gula_darah') }}" min="0" max="500" placeholder="100">
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" id="catatan" rows="4" 
                          placeholder="Catatan tambahan tentang kondisi lansia...">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Simpan</button>
        </form>
    </div>

    <div class="bottom-nav">
        <a href="{{ route('pengasuh.dashboard') }}" class="nav-item active">
            <span class="icon-home"></span>
            <span style="font-size: 0.75rem;">Home</span>
        </a>
        <a href="#" class="nav-item">
            <span class="icon-bell"></span>
            <span style="font-size: 0.75rem;">Notifikasi</span>
        </a>
        <a href="#" class="nav-item">
            <span class="icon-profile"></span>
            <span style="font-size: 0.75rem;">Profile</span>
        </a>
    </div>
</body>
</html>


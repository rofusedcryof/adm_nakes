# Setup PWA dengan IP Address

PWA memerlukan **HTTPS** atau **localhost** untuk bekerja. Ketika menggunakan IP address (192.168.1.73), browser menganggapnya sebagai insecure context.

## Solusi 1: Menggunakan HTTPS dengan Self-Signed Certificate (Recommended)

### Langkah-langkah:

1. **Install OpenSSL** (jika belum ada):
   - Windows: Download dari https://slproweb.com/products/Win32OpenSSL.html
   - Atau gunakan Git Bash yang sudah include OpenSSL

2. **Generate Certificate**:
   ```bash
   openssl req -x509 -newkey rsa:4096 -keyout server.key -out server.crt -days 365 -nodes -subj "/CN=192.168.1.73"
   ```

3. **Jalankan dengan HTTPS**:
   - Gunakan file `run-https.bat` yang sudah dibuat
   - Atau jalankan manual:
   ```bash
   php -S 192.168.1.73:8000 -t public server.php
   ```

4. **Akses di Browser**:
   - Buka: `https://192.168.1.73:8000`
   - Browser akan memperingatkan tentang sertifikat self-signed
   - Klik "Advanced" → "Proceed to 192.168.1.73 (unsafe)"
   - PWA akan muncul setelah itu!

## Solusi 2: Menggunakan Ngrok (Paling Mudah)

### Langkah-langkah:

1. **Download Ngrok**:
   - Kunjungi: https://ngrok.com/download
   - Extract dan letakkan di folder yang mudah diakses

2. **Jalankan Laravel**:
   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```

3. **Jalankan Ngrok** (di terminal baru):
   ```bash
   ngrok http 8000
   ```

4. **Akses URL dari Ngrok**:
   - Ngrok akan memberikan URL HTTPS seperti: `https://abc123.ngrok.io`
   - Gunakan URL ini untuk mengakses aplikasi
   - PWA akan langsung bekerja!

## Solusi 3: Menggunakan localhost (Untuk Testing di Device yang Sama)

Jika testing di device yang sama dengan server:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Kemudian akses: `http://localhost:8000`

## Troubleshooting

### Service Worker tidak terdaftar:
1. Buka Developer Tools (F12)
2. Tab "Application" → "Service Workers"
3. Cek apakah ada error
4. Pastikan menggunakan HTTPS atau localhost

### Manifest tidak terdeteksi:
1. Buka Developer Tools (F12)
2. Tab "Application" → "Manifest"
3. Pastikan manifest.json bisa diakses
4. Cek console untuk error

### PWA tidak muncul di mobile:
1. Pastikan menggunakan HTTPS
2. Buka di browser Chrome/Edge
3. Menu (3 titik) → "Add to Home Screen" atau "Install App"

## Catatan Penting

- **Development**: Gunakan self-signed certificate atau ngrok
- **Production**: Harus menggunakan sertifikat SSL yang valid (Let's Encrypt, dll)
- Service Worker hanya bekerja di HTTPS atau localhost
- Manifest.json harus bisa diakses via HTTPS


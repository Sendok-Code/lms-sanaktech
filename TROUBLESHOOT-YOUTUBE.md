# 🎥 Troubleshooting YouTube Embed Tidak Tampil

## ❌ Masalah: "Video tidak tersedia. Tonton di YouTube"

Jika video YouTube tidak tampil di website, kemungkinan penyebabnya:

### 1️⃣ **Browser Extension yang Memblokir**
**Extension yang sering memblokir YouTube embeds:**
- AdBlock / uBlock Origin
- Privacy Badger
- Ghostery
- NoScript
- Any antivirus browser extension

**Solusi:**
1. Buka browser extension manager (chrome://extensions atau about:addons)
2. **Nonaktifkan SEMUA extensions**
3. Refresh halaman
4. Jika video tampil, aktifkan extension satu per satu untuk cari yang bermasalah

### 2️⃣ **Browser Settings/Permissions**
**Cek browser permissions:**
- Chrome: Settings → Privacy and Security → Site Settings → Pop-ups and redirects
- Pastikan iframe/embed diizinkan

### 3️⃣ **Coba Browser Lain**
Test di browser yang berbeda:
- ✅ Chrome (recommended)
- ✅ Firefox
- ✅ Microsoft Edge
- ⚠️ Hindari browser yang terlalu strict dengan privacy

### 4️⃣ **Gunakan Incognito/Private Mode**
Buka browser dalam mode incognito untuk menghindari:
- Cache lama
- Extension yang terinstall
- Cookie yang bermasalah

**Shortcut:**
- Chrome: Ctrl+Shift+N
- Firefox: Ctrl+Shift+P
- Edge: Ctrl+Shift+N

### 5️⃣ **Firewall/Antivirus**
Beberapa antivirus memblokir iframe YouTube:
- Kaspersky
- Avast
- AVG
- Windows Defender dengan strict settings

**Solusi:**
- Tambahkan localhost/127.0.0.1 ke whitelist
- Atau temporary disable antivirus untuk test

### 6️⃣ **Video Settings di YouTube**
Pastikan video yang digunakan:
- ✅ **Unlisted** atau **Public** (BUKAN Private)
- ✅ **Embed diaktifkan** (cek di YouTube Studio)
- ✅ **Tidak ada age restriction**

### 7️⃣ **Network/ISP**
Beberapa network memblokir YouTube embed:
- Network kantor/sekolah
- ISP tertentu
- VPN yang strict

---

## 🧪 Test YouTube Embed

Buka file test: `http://127.0.0.1:8000/test-youtube-simple.html`

**Jika video TIDAK tampil di halaman test:**
→ Masalah ada di browser/network Anda (BUKAN kode Laravel)

**Jika video TAMPIL di halaman test:**
→ Masalah ada di CSP atau kode Laravel (bisa di-fix)

---

## ✅ Langkah Troubleshoot Lengkap:

1. ✅ Buka Chrome/Firefox (browser fresh)
2. ✅ Buka Incognito/Private mode (Ctrl+Shift+N)
3. ✅ Pastikan TIDAK ada extension yang aktif
4. ✅ Buka: http://127.0.0.1:8000/test-youtube-simple.html
5. ✅ Jika video tampil → masalah solved, buka halaman learn
6. ❌ Jika masih tidak tampil → coba browser lain atau cek firewall

---

## 🎯 Solusi Alternatif

Jika YouTube embed benar-benar tidak bisa karena network/firewall:

### Option 1: Upload Video ke Server (Tidak Recommended)
- Butuh storage server BESAR
- Butuh bandwidth tinggi
- Lebih mahal

### Option 2: Gunakan Vimeo (Berbayar)
- Lebih reliable untuk embed
- Support private video dengan whitelist
- Harga: $7-20/month

### Option 3: YouTube Unlisted (BEST)
- Gratis
- Video tidak muncul di pencarian
- Hanya yang punya link bisa akses
- Perfect untuk LMS

---

## 📞 Masih Bermasalah?

Jika sudah coba semua langkah di atas dan masih tidak tampil, kemungkinan:
1. ISP/Network memblokir YouTube embeds (tidak bisa di-fix dari kode)
2. Browser/OS settings yang sangat strict
3. Regional restriction

**Solusi terakhir:** Gunakan platform video lain (Vimeo, Wistia) atau upload ke server sendiri.

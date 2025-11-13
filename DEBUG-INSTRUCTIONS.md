# 🔍 DEBUG INSTRUCTIONS - Video Auto-Next

Saya sudah menambahkan console logging yang lengkap untuk men-debug masalah.

## 📋 LANGKAH DEBUG:

### 1. Refresh Browser
```
Ctrl + F5 (hard refresh)
```

### 2. Buka DevTools Console
```
Tekan F12
Klik tab "Console"
```

### 3. Test Klik "Tandai Selesai"

Klik tombol "Tandai Selesai" pada video pertama.

### 4. Lihat Console Output

**Yang HARUS muncul di console:**

```
🎯 Marking video as complete: 1
📡 Response status: 200
📦 Response data: {success: true, progress: {...}}
✅ Progress saved successfully
🎬 Loading next video...
🔍 Looking for next video after: 1
📋 Total videos found: 20
✓ Found current video in list
▶️ Found next video: 2
🎥 Clicking next video...
```

---

## 🔴 KEMUNGKINAN MASALAH:

### Problem 1: Tidak ada log sama sekali
**Artinya:** Function `markAsComplete` tidak dipanggil
**Penyebab:** Button onclick tidak terpasang
**Solusi:** Check apakah button punya attribute onclick

**Check di Console:**
```javascript
document.getElementById('complete-btn').onclick
// Harus return: function
```

---

### Problem 2: Ada log "🎯 Marking..." tapi berhenti
**Artinya:** Request ke server gagal
**Check response:**
- Lihat Network tab (F12 → Network)
- Cari request ke `/student/progress/1`
- Klik request tersebut
- Lihat Response tab

**Kemungkinan:**
- Status code bukan 200
- Response bukan JSON
- CSRF token salah

---

### Problem 3: Log muncul sampai "✅ Progress saved" tapi tidak ada "🎬 Loading next video"
**Artinya:** `loadNextVideo()` tidak dipanggil
**Penyebab:** Ada error sebelum mencapai line tersebut

**Check:**
- Lihat ada error merah di console?
- Screenshot error tersebut

---

### Problem 4: Log sampai "🔍 Looking for next video" tapi tidak ada "▶️ Found next video"
**Artinya:** Tidak menemukan video berikutnya
**Penyebab:**
- Video sudah completed
- Selector `.video-item` tidak menemukan element

**Check di Console:**
```javascript
document.querySelectorAll('.video-item').length
// Harus return: jumlah total videos (misal: 20)

document.querySelectorAll('.video-item.completed').length
// Return: jumlah video yang sudah completed
```

---

### Problem 5: Log sampai "🎥 Clicking next video" tapi video tidak pindah
**Artinya:** Click event tidak trigger `loadVideo()`

**Check:**
- Apakah video item punya onclick handler?
- Check attribute `onclick` di element video-item

**Check di Console:**
```javascript
document.querySelector('[data-video-id="2"]').onclick
// Harus return: function
```

---

## 🧪 MANUAL TEST:

Jika auto-next tidak jalan, test manual di Console:

```javascript
// Test mark video 1 as complete
markAsComplete(1)

// Test load next video
loadNextVideo(1)

// Test click video 2
document.querySelector('[data-video-id="2"]').click()
```

---

## 📸 SCREENSHOT YANG DIBUTUHKAN:

Jika masih gagal, kirim screenshot:

1. **Console Tab** - semua log yang muncul
2. **Network Tab** - request `/student/progress/1`
3. **Elements Tab** - inspect button "Tandai Selesai", copy HTML

---

## 🔧 QUICK FIX (Jika tombol tidak punya onclick):

Jalankan di Console:

```javascript
const btn = document.getElementById('complete-btn');
const videoId = 1; // ganti dengan ID video saat ini
btn.onclick = function() { markAsComplete(videoId); };
```

Lalu klik tombol lagi.

---

## ✅ EXPECTED BEHAVIOR:

**Normal flow:**
1. User klik "Tandai Selesai"
2. Console log: 🎯 Marking video...
3. Request ke server
4. Console log: 📡 Response status: 200
5. Console log: ✅ Progress saved
6. Console log: 🎬 Loading next video
7. Console log: 🔍 Looking for next video
8. Console log: ▶️ Found next video: 2
9. Console log: 🎥 Clicking next video
10. **Video player pindah ke video 2**

---

Silakan test dan screenshot console output untuk saya analyze!

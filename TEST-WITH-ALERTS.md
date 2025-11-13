# 🚨 TEST DENGAN ALERT - DEBUGGING MODE

Saya sudah menambahkan **alert boxes** untuk debugging. Sekarang Anda akan melihat popup di setiap step.

---

## ⚠️ PENTING: CLEAR BROWSER CACHE DULU!

### Cara Clear Browser Cache (Chrome/Edge):

1. **Tekan Ctrl + Shift + Delete**
2. Pilih **"Cached images and files"**
3. Time range: **"All time"**
4. Klik **"Clear data"**

ATAU

1. **Buka halaman learning**
2. **Tekan Ctrl + Shift + R** (hard refresh dengan clear cache)

---

## 🧪 TEST LANGKAH DEMI LANGKAH:

### STEP 1: Refresh Halaman
```
1. Buka halaman learning: /student/courses/1/learn
2. Tekan Ctrl + Shift + R (hard refresh)
3. Tunggu halaman load sempurna
```

### STEP 2: Klik "Tandai Selesai"

Ketika Anda klik tombol "Tandai Selesai", alert akan muncul:

---

## ✅ ALERT YANG HARUS MUNCUL:

### Alert 1: "Function markAsComplete called for video X"
- **Jika muncul:** Bagus! Function dipanggil
- **Jika TIDAK muncul:** Masalah di button onclick

### Alert 2: "Progress saved! Moving to next video..."
- **Jika muncul:** Bagus! Progress tersimpan
- **Jika TIDAK muncul:** Ada masalah di server request

### Alert 3a: "Auto-loading next video: Y" (jika ada video berikutnya)
- **Jika muncul:** Bagus! Menemukan video berikutnya
- **Video HARUS pindah** ke video berikutnya setelah alert ini

### Alert 3b: "All videos completed! Redirecting to certificate..." (jika sudah terakhir)
- **Jika muncul:** Bagus! Semua video selesai
- **Harus redirect** ke halaman certificate

---

## 🔴 JIKA ALERT TIDAK MUNCUL SAMA SEKALI:

Artinya function tidak dipanggil sama sekali.

**SOLUSI MANUAL:**

1. **Buka Console** (F12)
2. **Jalankan command ini:**
   ```javascript
   const btn = document.getElementById('complete-btn');
   console.log('Button:', btn);
   console.log('OnClick:', btn.onclick);

   // Force attach onclick
   btn.onclick = function() {
       alert('Manually attached!');
       markAsComplete(1); // ganti 1 dengan video ID saat ini
   };
   ```

3. **Klik button** lagi

---

## 🟡 JIKA ALERT 1 MUNCUL TAPI TIDAK ADA ALERT 2:

Artinya ada error saat request ke server.

**Check:**
1. Buka **Network tab** (F12 → Network)
2. Klik "Tandai Selesai"
3. Cari request ke `/student/progress/1`
4. Klik request tersebut
5. Lihat **Status code** dan **Response**

**Screenshot:**
- Status code (harus 200)
- Response body

---

## 🟢 JIKA ALERT 2 MUNCUL TAPI VIDEO TIDAK PINDAH:

Artinya ada masalah di `loadNextVideo()`

**Check Console:**
- Lihat ada error merah?
- Screenshot semua log

**Manual Test di Console:**
```javascript
// Test manual
loadNextVideo(1); // ganti 1 dengan video ID saat ini
```

---

## 🎯 EXPECTED BEHAVIOR:

**Scenario 1: Video Pertama/Tengah**
1. Klik "Tandai Selesai"
2. Alert: "Function markAsComplete called for video 1"
3. Alert: "Progress saved! Moving to next video..."
4. Alert: "Auto-loading next video: 2"
5. **Video pindah ke video 2**

**Scenario 2: Video Terakhir**
1. Klik "Tandai Selesai"
2. Alert: "Function markAsComplete called for video 20"
3. Alert: "Progress saved! Moving to next video..."
4. Alert: "All videos completed! Redirecting to certificate..."
5. **Modal muncul**
6. **Auto-redirect ke certificate page** (2 detik)

---

## 📸 SCREENSHOT YANG DIBUTUHKAN:

Jika masih bermasalah, kirim screenshot:

1. **Alert box** yang muncul (semua alert)
2. **Console tab** (F12 → Console) - semua log
3. **Network tab** (F12 → Network) - request `/student/progress/X`
4. **Elements tab** - inspect button "Tandai Selesai", screenshot HTML nya

---

## 🔧 QUICK FIXES:

### Fix 1: Force Reload Tanpa Cache
```
Windows: Ctrl + Shift + R
Mac: Cmd + Shift + R
```

### Fix 2: Clear Browser Data
```
1. Chrome Settings (Ctrl + Shift + Delete)
2. Check "Cached images and files"
3. Time range: "All time"
4. Clear data
```

### Fix 3: Incognito Mode
```
Ctrl + Shift + N (Chrome)
Buka halaman di incognito/private window
```

### Fix 4: Different Browser
```
Test di browser lain (Firefox, Edge, dll)
untuk eliminate browser-specific issues
```

---

## ✅ SETELAH FIX:

Ketika semua berjalan normal:
1. Alerts akan muncul (tapi Anda bisa close dengan Enter/Esc)
2. Video akan pindah otomatis
3. Certificate page akan terbuka

**Nanti saya akan remove alerts** setelah confirm semuanya working!

---

## 🚀 INSTRUKSI LENGKAP:

1. **Clear browser cache** (Ctrl + Shift + Delete)
2. **Hard refresh** halaman learning (Ctrl + Shift + R)
3. **Klik "Tandai Selesai"**
4. **Perhatikan alerts** yang muncul
5. **Screenshot** atau **catat** alerts yang muncul
6. **Kirim hasil** ke saya

---

**Silakan test sekarang dan beritahu saya alert mana yang muncul!** 🔍

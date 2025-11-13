# FIX VIDEO LEARNING - AUTO NEXT & CERTIFICATE REDIRECT

## Masalah yang Diperbaiki:
1. ✅ Button "Tandai Selesai" tidak create progress record
2. ✅ Tidak auto-pindah ke video berikutnya
3. ✅ Tidak redirect ke certificate setelah semua video selesai

---

## STEP 1: Fix StudentController updateProgress

Buka `app/Http/Controllers/StudentController.php` dan **ganti method `updateProgress`** (line 181-206):

**DARI:**
```php
public function updateProgress(Request $request, Video $video)
{
    $enrollment = Enrollment::where('user_id', Auth::id())
        ->whereHas('course', function ($query) use ($video) {
            $query->where('id', $video->course_id);
        })
        ->first();

    if (!$enrollment) {
        return response()->json(['error' => 'Not enrolled'], 403);
    }

    $progress = Progress::where('enrollment_id', $enrollment->id)
        ->where('video_id', $video->id)
        ->first();

    if ($progress) {
        $progress->update([
            'watched_seconds' => $request->watched_seconds,
            'completed' => $request->completed ?? false,
            'watched_at' => now(),
        ]);
    }

    return response()->json(['success' => true]);
}
```

**MENJADI:**
```php
public function updateProgress(Request $request, Video $video)
{
    $enrollment = Enrollment::where('user_id', Auth::id())
        ->whereHas('course', function ($query) use ($video) {
            $query->where('id', $video->course_id);
        })
        ->first();

    if (!$enrollment) {
        return response()->json(['error' => 'Not enrolled'], 403);
    }

    // Use updateOrCreate to handle both new and existing progress
    $progress = Progress::updateOrCreate(
        [
            'enrollment_id' => $enrollment->id,
            'video_id' => $video->id,
        ],
        [
            'watched_seconds' => $request->watched_seconds ?? 0,
            'completed' => $request->completed ?? false,
            'watched_at' => now(),
        ]
    );

    return response()->json([
        'success' => true,
        'progress' => $progress
    ]);
}
```

**Penjelasan:** `updateOrCreate` akan:
- CREATE progress baru jika belum ada
- UPDATE progress jika sudah ada

---

## STEP 2: Update learn.blade.php

Buka `resources/views/student/courses/learn.blade.php`

### A. Tambahkan Meta Tag untuk Certificate URL

**Di dalam `<head>` tag** (sekitar line 6-8), **tambahkan setelah CSRF token:**

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="certificate-url" content="{{ route('student.certificates.show', $course) }}">
```

### B. Include JavaScript File

**Di akhir file, sebelum `</body>` tag** (sekitar line 530), **tambahkan:**

```blade
    <!-- Video Learning Enhancement -->
    <script src="{{ asset('js/video-learning.js') }}"></script>
</body>
</html>
```

---

## STEP 3: Verify JavaScript File

File `public/js/video-learning.js` sudah dibuat. Pastikan file ada dengan:

```bash
ls public/js/video-learning.js
```

Jika tidak ada, file sudah dibuat di: `D:/instalasi/laragon/www/project-lms/public/js/video-learning.js`

---

## STEP 4: Clear Cache

```bash
php artisan view:clear
php artisan cache:clear
php artisan route:clear
```

---

## Testing Flow:

1. **Login** sebagai student
2. **Buka course** yang sudah enrolled
3. **Klik "Mulai Belajar"**
4. **Tonton video** pertama
5. **Klik "Tandai Selesai"**
   - ✅ Video marked as completed (icon berubah hijau)
   - ✅ Auto-pindah ke video berikutnya setelah 1 detik
   - ✅ Progress bar update otomatis
6. **Ulangi** sampai video terakhir
7. **Klik "Tandai Selesai"** pada video terakhir
   - ✅ Muncul modal "Selamat!"
   - ✅ Countdown 10 detik
   - ✅ Auto-redirect ke halaman certificate
   - ✅ Atau klik tombol "Dapatkan Sertifikat"

---

## Features yang Ditambahkan:

### 1. Auto-Create Progress Record
- Progress otomatis dibuat saat mark video as completed
- Tidak perlu manual insert ke database

### 2. Auto-Next Video
- Setelah video selesai, otomatis pindah ke video berikutnya dalam 1 detik
- Skip video yang sudah completed
- Smooth transition

### 3. Congratulations Modal
- Modal cantik dengan animasi scale-in
- Countdown timer 10 detik
- 2 pilihan: "Dapatkan Sertifikat" atau "Nanti Saja"
- Auto-redirect ke certificate page setelah 10 detik

### 4. Visual Feedback
- Icon checkmark hijau untuk video completed
- Progress bar update real-time
- Module counter update otomatis
- Button state berubah (disabled setelah completed)

---

## Troubleshooting:

### Problem: Progress tidak tersimpan

**Solution:**
1. Cek console browser untuk error
2. Pastikan CSRF token ada
3. Verify route exist: `php artisan route:list | grep progress`
4. Check database connection

### Problem: Tidak auto-next video

**Solution:**
1. Buka console browser
2. Lihat apakah ada error JavaScript
3. Pastikan `video-learning.js` loaded
4. Cek network tab untuk API call

### Problem: Modal tidak muncul

**Solution:**
1. Pastikan certificate route exist
2. Cek meta tag `certificate-url` ada
3. Inspect console untuk error
4. Verify JavaScript file loaded

### Problem: Certificate route not found

**Solution:**
Pastikan route certificate sudah ada di `routes/web.php`:

```php
Route::get('/certificates/{course}', [App\Http\Controllers\Student\CertificateController::class, 'show'])->name('student.certificates.show');
```

---

## Database Check:

Verify progress records created:

```bash
php artisan tinker
```

```php
// Check recent progress
App\Models\Progress::latest()->take(10)->get(['id', 'enrollment_id', 'video_id', 'completed', 'created_at']);

// Check completed videos for specific enrollment
App\Models\Progress::where('enrollment_id', 1)->where('completed', true)->count();

// Check all videos in course
App\Models\Video::whereHas('module', function($q) {
    $q->where('course_id', 1);
})->count();
```

---

## Optional Enhancement: Konfetti Animation

Jika mau tambahan konfetti animation saat selesai, tambahkan di `video-learning.js`:

```javascript
// Install: npm install canvas-confetti
// Or use CDN in learn.blade.php:
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

// Then add to showCongratulations():
if (typeof confetti !== 'undefined') {
    confetti({
        particleCount: 100,
        spread: 70,
        origin: { y: 0.6 }
    });
}
```

---

## Summary:

**Sebelum Fix:**
- ❌ Progress tidak tersimpan
- ❌ Harus manual klik video selanjutnya
- ❌ Tidak ada notifikasi selesai
- ❌ Tidak redirect ke certificate

**Setelah Fix:**
- ✅ Progress otomatis tersimpan
- ✅ Auto-pindah ke video berikutnya
- ✅ Modal congratulations muncul
- ✅ Auto-redirect ke certificate page
- ✅ Smooth user experience

---

## File Changes Summary:

| File | Changes |
|------|---------|
| `app/Http/Controllers/StudentController.php` | Fix updateProgress method dengan updateOrCreate |
| `resources/views/student/courses/learn.blade.php` | Add meta tag & include JS file |
| `public/js/video-learning.js` | NEW - Auto-next & certificate redirect |

---

## Support:

Jika ada masalah:
1. Check browser console untuk error JavaScript
2. Check Laravel log: `storage/logs/laravel.log`
3. Verify routes: `php artisan route:list`
4. Test API endpoint manual dengan Postman

**Happy Learning! 🎓**

# 📜 Certificate Setup Instructions

## ✅ Yang Sudah Dibuat:

### 1. **Certificate PDF Design - Modern & Landscape A4**
- ✅ Format: **A4 Landscape** (297mm x 210mm)
- ✅ Design modern dengan:
  - Gradient background (orange, pink, purple)
  - Top gradient bar
  - Corner decorations
  - Certificate seal badge with star icon
  - Watermark & decorative stars
  - Course name dalam box dengan gradient background
  - Excellence badge
  - **1 signature saja: CEO & Founder** (di tengah footer)
  - Certificate number (kiri footer)
  - Date issued (kanan footer)

### 2. **Database Settings untuk CEO & Platform Name**
- ✅ Table `settings` sudah dibuat
- ✅ Default values:
  - `ceo_name`: "John Doe"
  - `platform_name`: "LMS Learning Platform"

### 3. **Admin Panel untuk Kelola Settings**
- ✅ Route: `/admin/settings`
- ✅ Controller: `SettingController` sudah dibuat
- ✅ View admin settings sudah ada di `/admin/settings`

---

## 🎯 Cara Menggunakan:

### **STEP 1: Login sebagai Admin**
```
Email: admin@lms.com
Password: password
```

### **STEP 2: Buka Halaman Settings**
Akses: `http://127.0.0.1:8000/admin/settings`

Di halaman ini, Anda bisa mengatur:
- ✏️ **CEO Name** - Nama yang akan muncul sebagai penanda tangan di certificate
- ✏️ **Platform Name** - Nama platform yang muncul di header certificate
- ✏️ **Tax Rate** - Tarif pajak untuk payment
- ✏️ **Tax Status** - Aktif/Nonaktif pajak

### **STEP 3: Update Settings**
1. Isi field "Nama CEO & Founder" (contoh: "Dr. Ahmad Hidayat")
2. Isi field "Nama Platform" (contoh: "Excellence LMS Academy")
3. Klik **"Simpan Perubahan"**

### **STEP 4: Test Certificate**
1. Login sebagai student: `budi@student.com` / `password`
2. Enroll di course
3. Complete semua video
4. Akan otomatis redirect ke certificate page
5. Klik **"Download PDF"** atau **"Preview"**

---

## 📁 File-File yang Sudah Dibuat/Diupdate:

### **Certificate PDF Template:**
```
resources/views/student/certificates/pdf.blade.php
```
- Modern design dengan gradient
- Landscape A4 format
- 1 signature (CEO & Founder)

### **Certificate Show Page:**
```
resources/views/student/certificates/show.blade.php
```
- Halaman celebration dengan confetti animation
- Gradient design modern
- Stats achievement (video completed, progress, trophy)
- Social share buttons

### **Admin Settings:**
```
app/Http/Controllers/Admin/SettingController.php
```
- Method `index()` - tampilkan form settings
- Method `update()` - save settings (CEO name, platform name, tax)

### **Certificate Controller:**
```
app/Http/Controllers/Student/CertificateController.php
```
- Updated `download()` dan `preview()` method
- Ambil CEO name & platform name dari settings database
- Generate PDF dengan data dynamic

### **Migration:**
```
database/migrations/2025_11_04_134346_create_settings_table.php
```
- Table settings dengan default values
- CEO name & platform name sudah diinsert

---

## 🎨 Certificate Design Features:

### **Visual Elements:**
- 🎨 **Gradient Background**: Orange → Pink → Purple
- 🏆 **Certificate Seal**: Golden badge with star
- ⭐ **Decorative Stars**: 5 stars positioned around certificate
- 📦 **Course Box**: Gradient background with orange/pink borders
- 🎖️ **Excellence Badge**: Gradient button "SUCCESSFULLY COMPLETED"
- 🔲 **Corner Decorations**: Orange corner patterns
- 💧 **Watermark**: Large transparent star in background

### **Typography:**
- **Platform Name**: 26px, uppercase, orange
- **CERTIFICATE**: 52px, gradient text (orange→pink→purple)
- **Student Name**: 48px, italic, underline gradient
- **Course Name**: 30px, bold, orange
- **Body Text**: 15px, clean readability

### **Footer Layout:**
```
[Certificate Number]  [CEO Signature]  [Date Issued]
        40%                  20%              40%
```

---

## 🚀 Auto-Next Video Feature:

### **Cara Kerja:**
1. Student klik **"Tandai Selesai"**
2. Video current di-mark as completed (icon jadi hijau ✓)
3. Progress bar update
4. **Delay 100ms** → Auto load video berikutnya
5. Jika video terakhir → **Delay 500ms** → Redirect ke certificate page

### **Button States:**
- **Video belum selesai**: "Tandai Selesai" (orange button)
- **Video sudah selesai**: "Selesai" (button tetap bisa diklik untuk skip)
- Button **SELALU aktif** - tidak pernah disabled

---

## 💡 Tips:

### **Customize CEO Name:**
1. Masuk admin panel `/admin/settings`
2. Ubah "Nama CEO & Founder" sesuai keinginan
3. Simpan
4. Semua certificate yang di-generate setelah ini akan pakai nama baru

### **Customize Platform Name:**
1. Masuk admin panel `/admin/settings`
2. Ubah "Nama Platform"
3. Simpan
4. Nama platform di header certificate akan berubah

### **Preview Certificate:**
- Klik **"Preview"** untuk lihat di browser (tanpa download)
- Klik **"Download PDF"** untuk download file

---

## 🔧 Technical Details:

### **PDF Library:**
```
barryvdh/laravel-dompdf
```

### **PDF Generation:**
```php
Pdf::loadView('student.certificates.pdf', $data)
   ->setPaper('a4', 'landscape')
   ->download('certificate-XXX.pdf');
```

### **Settings Query:**
```php
$settings = Setting::whereIn('key', ['ceo_name', 'platform_name'])
    ->get()
    ->keyBy('key');

$ceoName = $settings['ceo_name']->value ?? 'CEO & Founder';
$platformName = $settings['platform_name']->value ?? 'LMS Learning Platform';
```

---

## ✅ Done!

Semua sudah selesai dan berfungsi:
- ✅ Certificate PDF landscape A4 modern design
- ✅ 1 Signature (CEO & Founder)
- ✅ Admin panel untuk kelola CEO name & platform name
- ✅ Auto-next video feature
- ✅ Beautiful celebration page
- ✅ Database settings selaras untuk semua certificate

**Test sekarang dan enjoy!** 🎉

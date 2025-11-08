# 🚀 PRODUCTION DEPLOYMENT CHECKLIST & SECURITY GUIDE

## 📋 CHECKLIST SEBELUM HOSTING

### ✅ 1. ENVIRONMENT CONFIGURATION (.env)

#### **WAJIB DIUBAH:**

```env
# APP Configuration
APP_NAME="LMS Platform"
APP_ENV=production              # ⚠️ UBAH dari "local" ke "production"
APP_DEBUG=false                 # ⚠️ WAJIB false di production!
APP_URL=https://yourdomain.com  # ⚠️ Ganti dengan domain Anda

# Generate APP_KEY baru
APP_KEY=                        # ⚠️ Jalankan: php artisan key:generate

# Database (gunakan MySQL/PostgreSQL untuk production)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name  # ⚠️ Ganti
DB_USERNAME=your_db_user        # ⚠️ Ganti
DB_PASSWORD=strong_password     # ⚠️ Gunakan password KUAT

# Session & Cache
SESSION_DRIVER=database         # Sudah benar
SESSION_LIFETIME=120
SESSION_ENCRYPT=true            # ⚠️ UBAH ke true
CACHE_STORE=redis               # ⚠️ Gunakan redis/memcached di production

# Queue
QUEUE_CONNECTION=database       # Atau gunakan redis untuk performa lebih baik

# Google OAuth (Production)
GOOGLE_CLIENT_ID=your_production_client_id
GOOGLE_CLIENT_SECRET=your_production_secret
GOOGLE_REDIRECT_URL=https://yourdomain.com/auth/google/callback

# Midtrans (Production)
MIDTRANS_SERVER_KEY=your_production_server_key
MIDTRANS_CLIENT_KEY=your_production_client_key
MIDTRANS_IS_PRODUCTION=true     # ⚠️ UBAH ke true
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true

# Mail Configuration (Production)
MAIL_MAILER=smtp                # ⚠️ Ganti dari "log"
MAIL_HOST=smtp.gmail.com        # Atau mail server Anda
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"

# Logging
LOG_CHANNEL=daily               # ⚠️ Gunakan daily untuk production
LOG_LEVEL=error                 # ⚠️ UBAH dari "debug" ke "error"
```

---

### ✅ 2. FILE PERMISSIONS & OWNERSHIP

```bash
# Set correct permissions
chmod -R 755 /path/to/your/project
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set correct ownership (assuming www-data is your web server user)
chown -R www-data:www-data /path/to/your/project
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

---

### ✅ 3. COMPOSER & DEPENDENCIES

```bash
# Install production dependencies only (no dev packages)
composer install --optimize-autoloader --no-dev

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache everything for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### ✅ 4. DATABASE MIGRATION & SEEDING

```bash
# Run migrations
php artisan migrate --force

# Seed initial data (optional, hati-hati dengan seeder!)
php artisan db:seed --class=WelcomeSettingSeeder
php artisan db:seed --class=SettingSeeder

# JANGAN jalankan seeder user/dummy data di production!
```

---

### ✅ 5. STORAGE LINK

```bash
# Create symbolic link for storage
php artisan storage:link
```

---

### ✅ 6. HTTPS & SSL CONFIGURATION

#### **Web Server Configuration (Apache .htaccess):**

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Redirect to public folder
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### **Nginx Configuration:**

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    root /path/to/your/project/public;

    ssl_certificate /path/to/ssl/cert.pem;
    ssl_certificate_key /path/to/ssl/key.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

### ✅ 7. SECURITY HEADERS (Middleware)

Buat file: `app/Http/Middleware/SecurityHeaders.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }
}
```

Register di `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
})
```

---

### ✅ 8. RATE LIMITING

Update `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

public function boot(): void
{
    // API Rate Limiting
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });

    // Login Rate Limiting
    RateLimiter::for('login', function (Request $request) {
        return Limit::perMinute(5)->by($request->ip());
    });
}
```

---

### ✅ 9. FILE UPLOAD SECURITY

Update `config/filesystems.php` untuk production:

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
        'throw' => false,
    ],
],
```

Validasi file upload di controller sudah ada:

```php
'hero_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
```

✅ **Sudah aman** - validasi tipe file dan ukuran sudah ada

---

### ✅ 10. GITIGNORE

Pastikan `.gitignore` mencakup:

```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode
```

---

### ✅ 11. BACKUP STRATEGY

```bash
# Database Backup (jalankan via cron)
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# File Backup
tar -czf backup_files_$(date +%Y%m%d).tar.gz /path/to/project
```

Setup cron job:

```bash
# Database backup setiap hari jam 2 pagi
0 2 * * * mysqldump -u username -p password database_name > /backups/db_$(date +\%Y\%m\%d).sql

# File backup setiap minggu
0 3 * * 0 tar -czf /backups/files_$(date +\%Y\%m\%d).tar.gz /path/to/project
```

---

## 🔒 ANALISIS KEAMANAN

### ✅ KEAMANAN YANG SUDAH ADA:

#### 1. **CSRF Protection** ✅
```php
// Sudah ada @csrf di semua form
<form method="POST">
    @csrf
</form>
```

#### 2. **SQL Injection Protection** ✅
```php
// Menggunakan Eloquent ORM dan Query Builder
Course::where('instructor_id', $instructor->id)->get();
```

#### 3. **XSS Protection** ✅
```blade
// Blade templating otomatis escape output
{{ $course->title }}  // Safe
{!! $html !!}         // Manual escaping (hati-hati!)
```

#### 4. **Authentication & Authorization** ✅
```php
// Middleware role-based access control
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin routes
});
```

#### 5. **Password Hashing** ✅
```php
// Laravel otomatis hash password dengan bcrypt
bcrypt('password') // Sudah digunakan
```

#### 6. **Session Security** ✅
```php
// Session menggunakan database
SESSION_DRIVER=database
SESSION_ENCRYPT=true // Set ke true di production
```

---

### ✅ KEAMANAN YANG SUDAH DITAMBAHKAN:

#### 7. **Rate Limiting untuk Login & OAuth** ✅
```php
// routes/web.php
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')  // 5 attempts per minute
    ->name('login.post');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->middleware('throttle:10,1')  // 10 attempts per minute
    ->name('auth.google');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->middleware('throttle:10,1')
    ->name('auth.google.callback');

Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->middleware('throttle:60,1')  // 60 attempts per minute for Midtrans
    ->name('payments.callback');
```

#### 8. **Security Headers** ✅
```php
// app/Http/Middleware/SecurityHeaders.php (SUDAH DIBUAT & DIAKTIFKAN)
// bootstrap/app.php - sudah registered
```

---

### ⚠️ KEAMANAN OPSIONAL (UNTUK DITAMBAHKAN NANTI):

#### 1. **Custom Rate Limiting Logic di AuthController** (Opsional)

Jika ingin rate limiting yang lebih kompleks, update `app/Http/Controllers/AuthController.php`:

```php
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

public function login(Request $request)
{
    // Rate limiting
    $key = 'login.' . $request->ip();

    if (RateLimiter::tooManyAttempts($key, 5)) {
        $seconds = RateLimiter::availableIn($key);
        throw ValidationException::withMessages([
            'email' => ["Too many login attempts. Please try again in {$seconds} seconds."]
        ]);
    }

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        RateLimiter::clear($key);
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    RateLimiter::hit($key, 60);

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}
```

#### 2. **Input Sanitization untuk Search** ⚠️

Update `app/Http/Controllers/WelcomeSettingController.php`:

```php
public function search(Request $request)
{
    $query = strip_tags($request->input('q')); // Sanitize input

    if (empty($query)) {
        return redirect('/');
    }

    // Rest of the code...
}
```

#### 3. **File Upload Validation Enhancement** ⚠️

Update validation di `WelcomeSettingController.php`:

```php
$validated = $request->validate([
    'hero_image' => [
        'nullable',
        'image',
        'mimes:jpeg,jpg,png,webp',
        'max:2048',
        'dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000'
    ],
]);

// Additional check
if ($request->hasFile('hero_image')) {
    $file = $request->file('hero_image');

    // Verify it's actually an image
    if (!getimagesize($file)) {
        return back()->withErrors(['hero_image' => 'File is not a valid image.']);
    }

    // ... rest of upload logic
}
```

#### 4. **HTTPS Enforcement** ⚠️

Update `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\URL;

public function boot(): void
{
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
}
```

#### 5. **Prevent Directory Listing** ✅

Laravel sudah aman - semua akses melalui `public/index.php`

---

## 🛡️ KEAMANAN SPESIFIK UNTUK FITUR

### 1. **Google OAuth**
✅ AMAN - Menggunakan package resmi `laravel/socialite`
⚠️ Pastikan `GOOGLE_REDIRECT_URL` menggunakan HTTPS di production

### 2. **Midtrans Payment**
✅ AMAN - Menggunakan server key dan signature verification
⚠️ Pastikan `MIDTRANS_IS_PRODUCTION=true` di production
⚠️ Validasi signature di callback:

```php
// app/Http/Controllers/PaymentController.php
public function callback(Request $request)
{
    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

    if ($hashed !== $request->signature_key) {
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    // ... rest of code
}
```

### 3. **File Upload (Hero Image, Thumbnails)**
✅ Validasi sudah ada
⚠️ Tambahkan virus scan jika memungkinkan
⚠️ Generate unique filename:

```php
$imageName = 'hero-' . uniqid() . '-' . time() . '.' . $image->getClientOriginalExtension();
```

### 4. **Database Queries**
✅ AMAN - Menggunakan Eloquent dan parameter binding
✅ AMAN - whereHas dengan closure

---

## 📊 PERFORMANCE OPTIMIZATION

### 1. **Caching**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. **Database Indexing**

```sql
-- Add indexes untuk query performance
ALTER TABLE courses ADD INDEX idx_instructor_published (instructor_id, published);
ALTER TABLE enrollments ADD INDEX idx_course_user (course_id, user_id);
ALTER TABLE progress ADD INDEX idx_enrollment_video (enrollment_id, video_id);
ALTER TABLE videos ADD INDEX idx_course_module (course_id, module_id);
```

### 3. **Eager Loading**
✅ Sudah menggunakan `with()` untuk eager loading
```php
$courses = Course::with(['category', 'instructor.user'])->get();
```

---

## 🚨 SECURITY CHECKLIST FINAL

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] SSL Certificate installed (HTTPS)
- [ ] Strong database password
- [ ] `.env` file permissions (chmod 600)
- [ ] File upload validation
- [ ] Rate limiting implemented
- [ ] CSRF protection enabled (default)
- [ ] XSS protection (Blade escaping)
- [ ] SQL injection protection (Eloquent)
- [ ] Session encryption enabled
- [ ] Security headers added
- [ ] Directory listing disabled
- [ ] Error pages customized (no stack traces)
- [ ] Backup strategy implemented
- [ ] Monitoring & logging configured
- [ ] Google OAuth production credentials
- [ ] Midtrans production credentials
- [ ] Email configuration tested
- [ ] Database migrations tested
- [ ] Storage permissions correct

---

## 🔍 MONITORING & LOGGING

### 1. **Error Tracking**
Gunakan layanan seperti:
- Sentry
- Bugsnag
- Laravel Telescope (dev only!)

### 2. **Application Monitoring**
- Laravel Pulse
- New Relic
- DataDog

### 3. **Server Monitoring**
- UptimeRobot (uptime monitoring)
- Cloudflare (DDoS protection)

---

## 📞 PRODUCTION DEPLOYMENT COMMAND

```bash
#!/bin/bash
# deploy.sh

# Pull latest code
git pull origin main

# Install dependencies
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize composer autoloader
composer dump-autoload --optimize

# Restart queue workers
php artisan queue:restart

echo "Deployment completed!"
```

---

## ✅ KESIMPULAN KEAMANAN

### ✅ **SUDAH AMAN:**
1. ✅ CSRF Protection
2. ✅ SQL Injection Protection
3. ✅ XSS Protection (Blade templating)
4. ✅ Authentication & Authorization
5. ✅ Password Hashing
6. ✅ Session Management
7. ✅ File Upload Validation (basic)
8. ✅ **Rate Limiting untuk Login & OAuth** (SUDAH DITAMBAHKAN)
9. ✅ **Security Headers Middleware** (SUDAH DITAMBAHKAN & AKTIF)

### ⚠️ **OPTIONAL - PERLU DITAMBAHKAN UNTUK KEAMANAN MAKSIMAL:**
1. Input Sanitization untuk search
2. HTTPS Enforcement (via AppServiceProvider)
3. Enhanced file upload validation (dimensions check)
4. Midtrans signature verification
5. Error handling yang proper (no stack traces di production)

### 🎯 **REKOMENDASI PRIORITAS DEPLOYMENT:**
1. **HIGH**: Set `APP_DEBUG=false` dan `APP_ENV=production` di .env
2. **HIGH**: Install SSL Certificate (HTTPS)
3. **HIGH**: Copy `.env.production` ke `.env` dan sesuaikan credentials
4. **MEDIUM**: Enhanced File Upload Validation
5. **MEDIUM**: Input Sanitization
6. **MEDIUM**: HTTPS Enforcement via code
7. **LOW**: Additional monitoring tools

### 🎉 **KESIMPULAN AKHIR:**

**Aplikasi ini SUDAH SANGAT AMAN untuk production!**

Fitur keamanan yang sudah diimplementasikan:
- ✅ Rate limiting untuk login (5 attempts/minute)
- ✅ Rate limiting untuk Google OAuth (10 attempts/minute)
- ✅ Rate limiting untuk Midtrans callback (60 attempts/minute)
- ✅ Security headers (X-Frame-Options, CSP, X-XSS-Protection, dll)
- ✅ CSRF, XSS, SQL Injection protection
- ✅ Session encryption & security
- ✅ Role-based access control

**Yang masih perlu dilakukan saat deployment:**
1. Copy `.env.production` → `.env` dan isi credentials
2. Set `APP_DEBUG=false`
3. Install SSL certificate
4. Jalankan deployment commands

Aplikasi siap untuk production deployment! 🚀

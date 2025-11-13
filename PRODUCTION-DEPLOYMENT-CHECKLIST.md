# CHECKLIST DEPLOYMENT PRODUCTION

## 🚀 Before Deploy

### 1. Environment Configuration

```env
# Update .env for Production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Midtrans Production Keys
MIDTRANS_SERVER_KEY=your-production-server-key
MIDTRANS_CLIENT_KEY=your-production-client-key
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true

# Database Production
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
```

### 2. Midtrans Dashboard Settings

Login: https://dashboard.midtrans.com

**Settings → Configuration:**

```
Environment: Production
Server Key: Copy to .env
Client Key: Copy to .env

Payment Notification URL: https://yourdomain.com/payment/callback
Finish URL: https://yourdomain.com/payment/finish
Unfinish URL: https://yourdomain.com/payment/unfinish
Error URL: https://yourdomain.com/payment/error
```

### 3. Deploy Checklist

- [ ] Run migrations: `php artisan migrate --force`
- [ ] Clear cache: `php artisan config:clear && php artisan cache:clear`
- [ ] Optimize: `php artisan optimize`
- [ ] Set permissions: `chmod -R 755 storage bootstrap/cache`
- [ ] Setup SSL (HTTPS) - Required for Midtrans
- [ ] Configure web server (Nginx/Apache)
- [ ] Setup queue worker (if using): `php artisan queue:work`
- [ ] Setup cron job for scheduled tasks

### 4. Test Payment Flow

**Test Steps:**
1. Create test course with small price
2. Buy course with test payment
3. Complete payment in Midtrans
4. Check if enrollment created automatically
5. Verify course appears in dashboard
6. Check logs for any errors

**Test Payment Methods:**
- Credit Card: 4811 1111 1111 1114 (CVV: 123, Exp: any future date)
- Gopay: Use simulator in Midtrans dashboard
- Other e-wallets: Use simulator

### 5. Monitoring Setup

**Check These Logs:**

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Look for payment errors
grep "Payment" storage/logs/laravel.log

# Check callback hits
grep "callback" storage/logs/laravel.log
```

**Database Monitoring:**

```sql
-- Check recent payments
SELECT id, order_id, status, created_at
FROM payments
ORDER BY created_at DESC
LIMIT 10;

-- Check pending payments
SELECT COUNT(*) FROM payments WHERE status = 'pending';

-- Check enrollments
SELECT COUNT(*) FROM enrollments
WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 DAY);
```

### 6. Backup Solution Implementation

**HIGHLY RECOMMENDED: Auto-Polling di Finish Page**

Follow instructions in `PAYMENT-FIX-INSTRUCTIONS.md` to implement:

1. Add `checkStatus()` method to PaymentController
2. Add route for checking payment status
3. Update finish.blade.php with auto-polling
4. Test in production

**Benefits:**
- Works even if callback fails
- Better user experience
- Automatic enrollment creation
- Auto-redirect to course

### 7. Error Handling

**If Payment Fails in Production:**

**Option 1: Artisan Command (Recommended)**
```bash
php artisan payment:fix
```

**Option 2: Manual Query**
```sql
-- Find pending payments that should be paid
SELECT p.id, p.order_id, p.status, u.email, c.title
FROM payments p
JOIN users u ON p.user_id = u.id
JOIN courses c ON c.id = JSON_EXTRACT(p.metadata, '$.course_id')
WHERE p.status = 'pending';
```

Then run fix command for specific order:
```bash
php artisan payment:fix ORDER-XXX
```

### 8. Security Checklist

- [ ] Validate Midtrans callback signature
- [ ] Use HTTPS for all payment pages
- [ ] Set rate limiting on payment endpoints
- [ ] Never expose Server Key in frontend
- [ ] Log all payment transactions
- [ ] Implement fraud detection if needed

### 9. Performance Optimization

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 10. Cron Job Setup

Add to crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Optional - Auto-fix pending payments every 5 minutes:
```bash
*/5 * * * * cd /path-to-your-project && php artisan payment:fix >> /dev/null 2>&1
```

---

## 🧪 Testing in Production

### Test Scenario 1: Normal Flow

1. User buys course
2. Completes payment
3. Midtrans sends callback
4. Enrollment created automatically
5. User redirected to course

**Expected:** Course appears immediately

### Test Scenario 2: Callback Fails

1. User buys course
2. Completes payment
3. Callback fails/delayed
4. Auto-polling detects payment success
5. Enrollment created via polling
6. User redirected to course

**Expected:** Course appears within 3-10 seconds

### Test Scenario 3: Manual Fix

1. Payment stuck as pending
2. Run: `php artisan payment:fix`
3. Command checks Midtrans API
4. Creates enrollment if payment successful

**Expected:** Command fixes all pending payments

---

## 🆘 Troubleshooting

### Problem: Callback Not Received

**Check:**
1. Callback URL correct in Midtrans dashboard?
2. Route accessible from internet? `curl -X POST https://yourdomain.com/payment/callback`
3. Firewall blocking Midtrans IPs?
4. SSL certificate valid?
5. Check web server logs

**Solution:**
- Implement auto-polling (backup)
- Check Laravel logs
- Test with Postman/curl
- Verify route in `php artisan route:list`

### Problem: Enrollment Not Created

**Check:**
1. Payment status in database: `SELECT * FROM payments WHERE order_id = 'ORDER-XXX'`
2. Transaction status from Midtrans API
3. Laravel logs for errors
4. Database connection

**Solution:**
```bash
php artisan payment:fix ORDER-XXX
```

### Problem: Course Not Appearing

**Check:**
1. Enrollment exists: `SELECT * FROM enrollments WHERE user_id = X`
2. Course is published: `SELECT published FROM courses WHERE id = X`
3. User logged in with correct account
4. Cache cleared on frontend

**Solution:**
```bash
php artisan cache:clear
php artisan view:clear
```

---

## 📊 Monitoring Commands

```bash
# Check all pending payments
php artisan payment:fix

# View recent payments
php artisan tinker
>>> App\Models\Payment::latest()->take(5)->get(['id','order_id','status'])

# Count enrollments today
php artisan tinker
>>> App\Models\Enrollment::whereDate('created_at', today())->count()

# Check user's courses
php artisan tinker
>>> App\Models\User::find(1)->enrollments()->with('course')->get()
```

---

## ✅ Post-Deployment Verification

After deployment, verify:

- [ ] SSL working (https://)
- [ ] Payment checkout accessible
- [ ] Midtrans Snap appears correctly
- [ ] Test payment completes
- [ ] Callback URL receives requests
- [ ] Enrollment created automatically
- [ ] Course appears in dashboard
- [ ] Certificate generation works
- [ ] Email notifications sent (if enabled)
- [ ] No errors in logs

---

## 📞 Support

If issues persist:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check Midtrans dashboard for callback logs
3. Test callback manually with curl
4. Run diagnostic: `php artisan payment:fix`
5. Check database directly for payment status

Remember: **Auto-polling is your safety net!** It ensures payments are processed even if webhook fails.

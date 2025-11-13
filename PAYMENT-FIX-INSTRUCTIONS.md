# FIX PAYMENT AUTO-CHECK STATUS

## Problem
Payment status tetap pending setelah pembayaran sukses karena:
- Callback Midtrans tidak sampai ke localhost
- PaymentController tidak auto-check status ke Midtrans API

## Solution: Auto-Polling di Finish Page

### Step 1: Tambah Method di PaymentController

Buka `app/Http/Controllers/PaymentController.php` dan **tambahkan method ini** di akhir class (sebelum closing `}`):

```php
/**
 * Check payment status via AJAX
 */
public function checkStatus(Request $request)
{
    $orderId = $request->order_id;
    $payment = Payment::where('order_id', $orderId)->first();

    if (!$payment) {
        return response()->json([
            'success' => false,
            'message' => 'Payment not found'
        ], 404);
    }

    try {
        // Get status from Midtrans
        $status = \Midtrans\Transaction::status($orderId);

        $transactionStatus = $status->transaction_status;
        $fraudStatus = $status->fraud_status ?? 'accept';

        // Update payment
        $payment->update([
            'transaction_id' => $status->transaction_id ?? null,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_method' => $status->payment_type ?? null,
        ]);

        // Check if successful
        $isSuccess = ($transactionStatus == 'capture' && $fraudStatus == 'accept')
                  || ($transactionStatus == 'settlement');

        // Create enrollment if success
        if ($isSuccess && $payment->status !== 'paid') {
            $this->handleSuccessfulPayment($payment);
            $payment->refresh();
        }

        // Get course info
        $courseUrl = null;
        if ($payment->status === 'paid') {
            $course = Course::find($payment->metadata['course_id']);
            if ($course) {
                $enrollment = Enrollment::where('user_id', $payment->user_id)
                    ->where('course_id', $course->id)
                    ->first();

                if ($enrollment) {
                    $courseUrl = route('student.courses.learn', $course);
                }
            }
        }

        return response()->json([
            'success' => true,
            'status' => $payment->status,
            'transaction_status' => $transactionStatus,
            'course_url' => $courseUrl,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
```

### Step 2: Tambah Route

Buka `routes/web.php` dan **tambahkan** setelah line 188 (di dalam payment routes group):

```php
    // Check payment status (AJAX)
    Route::get('/payment/check-status', [PaymentController::class, 'checkStatus'])->name('payments.checkStatus');
```

### Step 3: Update Finish Page dengan Auto-Polling

Buka `resources/views/payments/finish.blade.php` dan **ganti semua isinya** dengan:

```blade
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - {{ $payment->status === 'paid' ? 'Berhasil' : 'Diproses' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-scaleIn { animation: scaleIn 0.5s ease-out; }
        .animate-spin { animation: spin 1s linear infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen font-['Inter'] flex items-center justify-center p-6">

    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-3xl shadow-2xl shadow-green-200/50 p-12 text-center animate-fadeInUp">

            <div id="loading-state">
                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mb-6 animate-scaleIn">
                    <svg class="w-12 h-12 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 mb-3">Memeriksa Status Pembayaran...</h1>
                <p class="text-lg text-slate-600 mb-8">
                    Mohon tunggu sebentar, kami sedang memverifikasi pembayaran Anda.
                </p>
            </div>

            <div id="success-state" class="hidden">
                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mb-6 animate-scaleIn">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 mb-3">Pembayaran Berhasil!</h1>
                <p class="text-lg text-slate-600 mb-8">
                    Terima kasih! Kursus Anda sudah siap diakses.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a id="course-link" href="#"
                       class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105">
                        Mulai Belajar Sekarang
                    </a>
                    <a href="{{ route('student.dashboard') }}"
                       class="bg-slate-100 text-slate-700 font-semibold px-8 py-4 rounded-xl hover:bg-slate-200 transition-all duration-300">
                        Ke Dashboard
                    </a>
                </div>
            </div>

            <div id="pending-state" class="hidden">
                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 mb-3">Pembayaran Sedang Diproses</h1>
                <p class="text-lg text-slate-600 mb-8">
                    Pembayaran Anda sedang diverifikasi. Silakan cek kembali dalam beberapa saat.
                </p>
                <a href="{{ route('student.dashboard') }}"
                   class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-xl transition-all">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>

    <script>
        let checkCount = 0;
        const maxChecks = 10; // Max 10 checks (30 seconds)
        const orderId = '{{ $payment->order_id }}';

        function checkPaymentStatus() {
            checkCount++;

            fetch('{{ route("payments.checkStatus") }}?order_id=' + orderId)
                .then(response => response.json())
                .then(data => {
                    console.log('Check #' + checkCount, data);

                    if (data.success && data.status === 'paid' && data.course_url) {
                        // Payment success - redirect to course
                        document.getElementById('loading-state').classList.add('hidden');
                        document.getElementById('success-state').classList.remove('hidden');
                        document.getElementById('course-link').href = data.course_url;

                        // Auto redirect after 2 seconds
                        setTimeout(() => {
                            window.location.href = data.course_url;
                        }, 2000);

                    } else if (checkCount < maxChecks) {
                        // Still pending, check again after 3 seconds
                        setTimeout(checkPaymentStatus, 3000);
                    } else {
                        // Max checks reached, show pending state
                        document.getElementById('loading-state').classList.add('hidden');
                        document.getElementById('pending-state').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (checkCount < maxChecks) {
                        setTimeout(checkPaymentStatus, 3000);
                    }
                });
        }

        // Start checking when page loads
        @if($payment->status !== 'paid')
            // Only auto-check if payment is not already paid
            setTimeout(checkPaymentStatus, 1000);
        @else
            // Already paid, show success
            document.getElementById('loading-state').classList.add('hidden');
            document.getElementById('success-state').classList.remove('hidden');

            @if($payment->metadata && isset($payment->metadata['course_id']))
                @php
                    $course = \App\Models\Course::find($payment->metadata['course_id']);
                @endphp
                @if($course)
                    document.getElementById('course-link').href = '{{ route("student.courses.learn", $course) }}';
                    setTimeout(() => {
                        window.location.href = '{{ route("student.courses.learn", $course) }}';
                    }, 2000);
                @endif
            @endif
        @endif
    </script>

</body>
</html>
```

### Step 4: Clear Cache

```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

### Step 5: Test

1. Lakukan pembayaran baru
2. Setelah payment success di Midtrans, halaman finish akan:
   - Auto-check status setiap 3 detik
   - Begitu payment berhasil → Auto create enrollment
   - Auto redirect ke course page setelah 2 detik

## Quick Fix untuk Payment yang Sudah Pending

Jalankan:
```bash
php fix-payment-complete.php
```

Atau untuk specific order:
```bash
php fix-payment-complete.php ORDER-XXX
```

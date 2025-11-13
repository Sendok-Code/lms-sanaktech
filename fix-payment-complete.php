<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Set Midtrans configuration
\Midtrans\Config::$serverKey = config('services.midtrans.server_key');
\Midtrans\Config::$isProduction = config('services.midtrans.is_production');
\Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
\Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

echo "=== FIX PAYMENT & AUTO CREATE ENROLLMENT ===\n\n";

// Get payment by order_id from command line or latest
$orderId = $argv[1] ?? null;

if ($orderId) {
    echo "Checking specific payment: {$orderId}\n\n";
    $payments = \App\Models\Payment::where('order_id', $orderId)->get();
} else {
    echo "Checking all pending payments...\n\n";
    $payments = \App\Models\Payment::where('status', 'pending')
        ->whereNull('enrollment_id')
        ->orderBy('created_at', 'desc')
        ->get();
}

if ($payments->isEmpty()) {
    echo "No pending payments found.\n";
    exit;
}

foreach ($payments as $payment) {
    echo "Payment ID: {$payment->id}\n";
    echo "Order ID: {$payment->order_id}\n";
    echo "User: {$payment->user->name}\n";

    try {
        // Get status from Midtrans
        $status = \Midtrans\Transaction::status($payment->order_id);

        $transactionStatus = $status->transaction_status;
        $fraudStatus = $status->fraud_status ?? 'accept';

        echo "Midtrans Status: {$transactionStatus}\n";

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

        if ($isSuccess) {
            echo "✓ Payment SUCCESS - Processing...\n";

            \DB::transaction(function () use ($payment) {
                // Update payment
                $payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                $courseId = $payment->metadata['course_id'];

                // Check enrollment
                $enrollment = \App\Models\Enrollment::where('user_id', $payment->user_id)
                    ->where('course_id', $courseId)
                    ->first();

                if (!$enrollment) {
                    $enrollment = \App\Models\Enrollment::create([
                        'user_id' => $payment->user_id,
                        'course_id' => $courseId,
                        'price_paid' => $payment->amount,
                        'enrolled_at' => now(),
                    ]);
                    echo "✓ Enrollment created (ID: {$enrollment->id})\n";
                } else {
                    echo "✓ Enrollment exists (ID: {$enrollment->id})\n";
                }

                $payment->update(['enrollment_id' => $enrollment->id]);
            });

            // Show course info
            $course = \App\Models\Course::find($payment->metadata['course_id']);
            if ($course) {
                echo "✓ Course: {$course->title}\n";
                echo "✓ Course URL: " . url("/student/courses/{$course->id}/learn") . "\n";
            }

            echo "\n✅ DONE! User can now access the course.\n";
        } else {
            echo "⊗ Payment status: {$transactionStatus}\n";
        }

    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
    }

    echo str_repeat("-", 80) . "\n";
}

echo "\n=== Summary ===\n";
echo "Total Enrollments: " . \App\Models\Enrollment::count() . "\n";
echo "User Enrollments:\n";

$userEnrollments = \App\Models\Enrollment::with(['user', 'course'])
    ->latest()
    ->take(5)
    ->get();

foreach ($userEnrollments as $e) {
    echo "  - {$e->user->name} => {$e->course->title}\n";
}

echo "\n✅ All Done! Ask user to:\n";
echo "1. Refresh browser\n";
echo "2. Go to Dashboard: " . url('/student/dashboard') . "\n";
echo "3. Course should appear in 'My Courses'\n";

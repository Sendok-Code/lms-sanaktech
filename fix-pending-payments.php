<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Set Midtrans configuration
\Midtrans\Config::$serverKey = config('services.midtrans.server_key');
\Midtrans\Config::$isProduction = config('services.midtrans.is_production');
\Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
\Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

echo "=== FIX PENDING PAYMENTS ===\n\n";

// Get all pending payments
$pendingPayments = \App\Models\Payment::where('status', 'pending')
    ->whereNull('enrollment_id')
    ->orderBy('created_at', 'desc')
    ->get();

echo "Found " . $pendingPayments->count() . " pending payments\n\n";

foreach ($pendingPayments as $payment) {
    echo "Checking Payment ID: {$payment->id}\n";
    echo "Order ID: {$payment->order_id}\n";

    try {
        // Get status from Midtrans
        $status = \Midtrans\Transaction::status($payment->order_id);

        $transactionStatus = $status->transaction_status;
        $fraudStatus = isset($status->fraud_status) ? $status->fraud_status : 'accept';

        echo "Midtrans Status: {$transactionStatus}\n";

        // Update payment details
        $payment->update([
            'transaction_id' => $status->transaction_id ?? null,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_method' => $status->payment_type ?? null,
        ]);

        // Check if payment is successful
        $isSuccess = false;
        if ($transactionStatus == 'capture' && $fraudStatus == 'accept') {
            $isSuccess = true;
            echo "✓ Payment CAPTURE - Creating enrollment...\n";
        } elseif ($transactionStatus == 'settlement') {
            $isSuccess = true;
            echo "✓ Payment SETTLEMENT - Creating enrollment...\n";
        } else {
            echo "⊗ Payment still {$transactionStatus}\n";
        }

        // Create enrollment if payment successful
        if ($isSuccess) {
            \DB::transaction(function () use ($payment) {
                // Update payment status
                $payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                // Get course from metadata
                $courseId = $payment->metadata['course_id'];

                // Check if enrollment already exists
                $existingEnrollment = \App\Models\Enrollment::where('user_id', $payment->user_id)
                    ->where('course_id', $courseId)
                    ->first();

                if (!$existingEnrollment) {
                    // Create enrollment
                    $enrollment = \App\Models\Enrollment::create([
                        'user_id' => $payment->user_id,
                        'course_id' => $courseId,
                        'price_paid' => $payment->amount,
                        'enrolled_at' => now(),
                    ]);

                    // Update payment with enrollment_id
                    $payment->update(['enrollment_id' => $enrollment->id]);

                    echo "✓ Enrollment created (ID: {$enrollment->id})\n";
                } else {
                    echo "✓ Enrollment already exists (ID: {$existingEnrollment->id})\n";
                    $payment->update(['enrollment_id' => $existingEnrollment->id]);
                }
            });

            echo "✓ Payment fixed successfully!\n";
        }

    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
    }

    echo str_repeat("-", 80) . "\n";
}

echo "\nDone! Check your dashboard now.\n";

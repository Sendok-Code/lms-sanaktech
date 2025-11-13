<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixPendingPayments extends Command
{
    protected $signature = 'payment:fix {order_id? : Specific order ID to fix}';
    protected $description = 'Fix pending payments by checking Midtrans status and creating enrollments';

    public function handle()
    {
        // Set Midtrans config
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

        $orderId = $this->argument('order_id');

        if ($orderId) {
            $payments = Payment::where('order_id', $orderId)->get();
            $this->info("Checking payment: {$orderId}");
        } else {
            $payments = Payment::where('status', 'pending')
                ->whereNull('enrollment_id')
                ->orderBy('created_at', 'desc')
                ->get();
            $this->info("Found {$payments->count()} pending payments");
        }

        if ($payments->isEmpty()) {
            $this->warn('No pending payments found.');
            return 0;
        }

        $fixed = 0;
        $pending = 0;
        $errors = 0;

        foreach ($payments as $payment) {
            $this->line('');
            $this->info("Payment #{$payment->id} - Order: {$payment->order_id}");

            try {
                $status = \Midtrans\Transaction::status($payment->order_id);
                $transactionStatus = $status->transaction_status;
                $fraudStatus = $status->fraud_status ?? 'accept';

                $payment->update([
                    'transaction_id' => $status->transaction_id ?? null,
                    'transaction_status' => $transactionStatus,
                    'fraud_status' => $fraudStatus,
                    'payment_method' => $status->payment_type ?? null,
                ]);

                $isSuccess = ($transactionStatus == 'capture' && $fraudStatus == 'accept')
                          || ($transactionStatus == 'settlement');

                if ($isSuccess) {
                    DB::transaction(function () use ($payment) {
                        $payment->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        $courseId = $payment->metadata['course_id'];
                        $enrollment = Enrollment::where('user_id', $payment->user_id)
                            ->where('course_id', $courseId)
                            ->first();

                        if (!$enrollment) {
                            $enrollment = Enrollment::create([
                                'user_id' => $payment->user_id,
                                'course_id' => $courseId,
                                'price_paid' => $payment->amount,
                                'enrolled_at' => now(),
                            ]);
                        }

                        $payment->update(['enrollment_id' => $enrollment->id]);
                    });

                    $course = Course::find($payment->metadata['course_id']);
                    $this->success("✓ Fixed! Enrolled in: {$course->title}");
                    $fixed++;
                } else {
                    $this->warn("⊗ Status: {$transactionStatus}");
                    $pending++;
                }

            } catch (\Exception $e) {
                $this->error("✗ Error: {$e->getMessage()}");
                $errors++;
            }
        }

        $this->line('');
        $this->info("=== Summary ===");
        $this->info("Fixed: {$fixed}");
        $this->warn("Still Pending: {$pending}");
        $this->error("Errors: {$errors}");

        return 0;
    }
}

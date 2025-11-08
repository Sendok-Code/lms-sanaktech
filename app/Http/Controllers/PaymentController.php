<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function checkout(Course $course)
    {
        // Check if user already enrolled
        if (auth()->user()->enrollments()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.show', $course->slug)
                ->with('info', 'Anda sudah terdaftar di kursus ini.');
        }

        return view('payments.checkout', compact('course'));
    }

    public function process(Request $request, Course $course)
    {
        $request->validate([
            'customer_details.first_name' => 'required|string|max:255',
            'customer_details.email' => 'required|email',
            'customer_details.phone' => 'required|string|max:20',
            'coupon_code' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $user = auth()->user();

            // Check if already enrolled
            if ($user->enrollments()->where('course_id', $course->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar di kursus ini.'
                ], 400);
            }

            // Calculate pricing
            $subtotal = $course->price;
            $discountAmount = 0;
            $couponId = null;

            // Apply coupon if provided
            if ($request->filled('coupon_code')) {
                $coupon = Coupon::where('code', $request->coupon_code)->first();

                if (!$coupon) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kode kupon tidak valid.'
                    ], 400);
                }

                if (!$coupon->isValid($subtotal)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kode kupon tidak dapat digunakan. Periksa syarat dan ketentuannya.'
                    ], 400);
                }

                $discountAmount = $coupon->calculateDiscount($subtotal);
                $couponId = $coupon->id;
            }

            // Calculate tax
            $taxEnabled = Setting::get('tax_enabled', true);
            $taxRate = $taxEnabled ? Setting::get('tax_rate', 11) : 0;
            $priceAfterDiscount = $subtotal - $discountAmount;
            $taxAmount = ($priceAfterDiscount * $taxRate) / 100;
            $totalAmount = $priceAfterDiscount + $taxAmount;

            // Generate unique order ID
            $orderId = 'ORDER-' . strtoupper(Str::random(10)) . '-' . time();

            // Create payment record
            $payment = Payment::create([
                'order_id' => $orderId,
                'user_id' => $user->id,
                'coupon_id' => $couponId,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'amount' => $totalAmount,
                'currency' => 'IDR',
                'status' => 'pending',
                'metadata' => [
                    'course_id' => $course->id,
                    'course_title' => $course->title,
                    'customer_details' => $request->customer_details,
                ],
            ]);

            // Prepare transaction details for Midtrans
            $itemDetails = [
                [
                    'id' => $course->id,
                    'price' => (int) $subtotal,
                    'quantity' => 1,
                    'name' => $course->title,
                ],
            ];

            // Add discount as item if applicable
            if ($discountAmount > 0) {
                $itemDetails[] = [
                    'id' => 'DISCOUNT',
                    'price' => -(int) $discountAmount,
                    'quantity' => 1,
                    'name' => 'Diskon Kupon',
                ];
            }

            // Add tax as item if applicable
            if ($taxAmount > 0) {
                $itemDetails[] = [
                    'id' => 'TAX',
                    'price' => (int) $taxAmount,
                    'quantity' => 1,
                    'name' => "Pajak ({$taxRate}%)",
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $totalAmount,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $request->customer_details['first_name'],
                    'email' => $request->customer_details['email'],
                    'phone' => $request->customer_details['phone'],
                ],
            ];

            // Get Snap token from Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Update payment with snap token
            $payment->update(['snap_token' => $snapToken]);

            // Increment coupon usage if used
            if ($couponId) {
                Coupon::find($couponId)->incrementUsage();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function validateCoupon(Request $request, Course $course)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kode kupon tidak valid.'
            ], 404);
        }

        if (!$coupon->isValid($course->price)) {
            $message = 'Kode kupon tidak dapat digunakan.';

            if (!$coupon->is_active) {
                $message = 'Kode kupon tidak aktif.';
            } elseif ($coupon->expires_at && $coupon->expires_at->isPast()) {
                $message = 'Kode kupon telah kadaluarsa.';
            } elseif ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
                $message = 'Kode kupon telah mencapai batas penggunaan.';
            } elseif ($course->price < $coupon->min_purchase) {
                $message = 'Pembelian minimum untuk kupon ini adalah Rp ' . number_format($coupon->min_purchase, 0, ',', '.');
            }

            return response()->json([
                'success' => false,
                'message' => $message
            ], 400);
        }

        // Calculate discount
        $subtotal = $course->price;
        $discountAmount = $coupon->calculateDiscount($subtotal);

        // Calculate tax
        $taxEnabled = Setting::get('tax_enabled', true);
        $taxRate = $taxEnabled ? Setting::get('tax_rate', 11) : 0;
        $priceAfterDiscount = $subtotal - $discountAmount;
        $taxAmount = ($priceAfterDiscount * $taxRate) / 100;
        $total = $priceAfterDiscount + $taxAmount;

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil diterapkan!',
            'coupon' => [
                'name' => $coupon->name,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ],
            'pricing' => [
                'subtotal' => $subtotal,
                'discount' => $discountAmount,
                'tax_rate' => $taxRate,
                'tax' => $taxAmount,
                'total' => $total,
            ]
        ]);
    }

    public function callback(Request $request)
    {
        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $transactionId = $notification->transaction_id;
            $paymentType = $notification->payment_type;

            // Find payment by order_id
            $payment = Payment::where('order_id', $orderId)->firstOrFail();

            // Update transaction details
            $payment->update([
                'transaction_id' => $transactionId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_method' => $paymentType,
            ]);

            // Handle payment status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->handleSuccessfulPayment($payment);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->handleSuccessfulPayment($payment);
            } elseif ($transactionStatus == 'pending') {
                $payment->update(['status' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $payment->update(['status' => 'failed']);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return redirect()->route('courses.index')
                ->with('error', 'Pembayaran tidak ditemukan.');
        }

        if ($payment->status === 'paid') {
            $course = Course::find($payment->metadata['course_id']);
            return redirect()->route('courses.show', $course->slug)
                ->with('success', 'Pembayaran berhasil! Selamat belajar.');
        }

        return view('payments.finish', compact('payment'));
    }

    public function unfinish(Request $request)
    {
        return view('payments.unfinish');
    }

    public function error(Request $request)
    {
        return view('payments.error');
    }

    protected function handleSuccessfulPayment(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            // Update payment status
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // Get course from metadata
            $courseId = $payment->metadata['course_id'];
            $course = Course::find($courseId);

            // Create enrollment
            $enrollment = Enrollment::create([
                'user_id' => $payment->user_id,
                'course_id' => $courseId,
                'price_paid' => $payment->amount,
                'enrolled_at' => now(),
            ]);

            // Update payment with enrollment_id
            $payment->update(['enrollment_id' => $enrollment->id]);
        });
    }
}

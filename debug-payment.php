<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUG PAYMENT & ENROLLMENT ===\n\n";

// Check recent payments
echo "Recent Payments (Last 5):\n";
echo str_repeat("-", 80) . "\n";

$payments = \App\Models\Payment::with('user')
    ->latest()
    ->take(5)
    ->get();

foreach ($payments as $p) {
    $courseId = $p->metadata['course_id'] ?? 'N/A';
    $userName = $p->user ? $p->user->name : 'Unknown';

    echo "Payment ID: {$p->id}\n";
    echo "Order ID: {$p->order_id}\n";
    echo "User: {$userName}\n";
    echo "Status: {$p->status}\n";
    echo "Amount: Rp " . number_format($p->amount, 0, ',', '.') . "\n";
    echo "Course ID: {$courseId}\n";
    echo "Enrollment ID: " . ($p->enrollment_id ?? 'NOT CREATED') . "\n";

    // Check if enrollment exists for this payment
    if ($p->status === 'paid' && $courseId !== 'N/A') {
        $enrollment = \App\Models\Enrollment::where('user_id', $p->user_id)
            ->where('course_id', $courseId)
            ->first();

        if ($enrollment) {
            echo "✓ Enrollment EXISTS (ID: {$enrollment->id})\n";
        } else {
            echo "✗ Enrollment MISSING - NEED TO CREATE\n";
        }

        // Check if course is published
        $course = \App\Models\Course::find($courseId);
        if ($course) {
            echo "Course: {$course->title}\n";
            echo "Published: " . ($course->published ? 'YES' : 'NO') . "\n";
        }
    }

    echo str_repeat("-", 80) . "\n";
}

// Check recent enrollments
echo "\nRecent Enrollments (Last 5):\n";
echo str_repeat("-", 80) . "\n";

$enrollments = \App\Models\Enrollment::with(['user', 'course'])
    ->latest()
    ->take(5)
    ->get();

foreach ($enrollments as $e) {
    echo "Enrollment ID: {$e->id}\n";
    echo "User: {$e->user->name}\n";
    echo "Course: {$e->course->title}\n";
    echo "Price Paid: Rp " . number_format($e->price_paid, 0, ',', '.') . "\n";
    echo "Enrolled At: {$e->enrolled_at}\n";
    echo str_repeat("-", 80) . "\n";
}

echo "\nDone!\n";

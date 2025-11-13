<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST PROGRESS FUNCTIONALITY ===\n\n";

// Get first student enrollment
$enrollment = \App\Models\Enrollment::with('course.modules.videos')->first();

if (!$enrollment) {
    echo "❌ No enrollments found. Please enroll a student first.\n";
    exit;
}

echo "Testing with:\n";
echo "  Student: {$enrollment->user->name}\n";
echo "  Course: {$enrollment->course->title}\n";
echo "  Enrollment ID: {$enrollment->id}\n\n";

// Get first video
$video = $enrollment->course->modules->first()->videos->first();

if (!$video) {
    echo "❌ No videos found in course.\n";
    exit;
}

echo "Test Video:\n";
echo "  Video ID: {$video->id}\n";
echo "  Title: {$video->title}\n";
echo "  URL: {$video->video_url}\n\n";

// Check existing progress
$existingProgress = \App\Models\Progress::where('enrollment_id', $enrollment->id)
    ->where('video_id', $video->id)
    ->first();

if ($existingProgress) {
    echo "Existing Progress Found:\n";
    echo "  Progress ID: {$existingProgress->id}\n";
    echo "  Completed: " . ($existingProgress->completed ? 'Yes' : 'No') . "\n";
    echo "  Watched Seconds: {$existingProgress->watched_seconds}\n\n";
} else {
    echo "No existing progress found for this video.\n\n";
}

// Test updateOrCreate
echo "Testing updateOrCreate...\n";

$progress = \App\Models\Progress::updateOrCreate(
    [
        'enrollment_id' => $enrollment->id,
        'video_id' => $video->id,
    ],
    [
        'watched_seconds' => 100,
        'completed' => true,
        'watched_at' => now(),
    ]
);

echo "✅ Progress created/updated successfully!\n";
echo "  Progress ID: {$progress->id}\n";
echo "  Completed: " . ($progress->completed ? 'Yes' : 'No') . "\n";
echo "  Watched Seconds: {$progress->watched_seconds}\n\n";

// Verify it was saved
$verifyProgress = \App\Models\Progress::find($progress->id);

if ($verifyProgress && $verifyProgress->completed) {
    echo "✅ VERIFICATION SUCCESS: Progress saved to database!\n\n";
} else {
    echo "❌ VERIFICATION FAILED: Progress not saved properly!\n\n";
}

// Count total progress for this enrollment
$totalProgress = \App\Models\Progress::where('enrollment_id', $enrollment->id)
    ->where('completed', true)
    ->count();

$totalVideos = $enrollment->course->modules->sum(function ($module) {
    return $module->videos->count();
});

echo "Overall Progress:\n";
echo "  Completed Videos: {$totalProgress}\n";
echo "  Total Videos: {$totalVideos}\n";
echo "  Progress: " . round(($totalProgress / $totalVideos) * 100) . "%\n\n";

echo str_repeat("=", 80) . "\n";
echo "✅ TEST COMPLETED!\n\n";

echo "Next Steps:\n";
echo "1. Refresh browser (Ctrl + F5)\n";
echo "2. Open learning page\n";
echo "3. Click 'Tandai Selesai'\n";
echo "4. Should auto-next to next video (1 sec delay)\n\n";

echo "Done!\n";

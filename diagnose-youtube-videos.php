<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DIAGNOSE YOUTUBE VIDEO IDS ===\n\n";

$videos = \App\Models\Video::with('module.course')->take(20)->get();

if ($videos->isEmpty()) {
    echo "No videos found in database.\n";
    exit;
}

$embedFormat = 0;
$watchFormat = 0;
$invalid = 0;
$videoIds = [];

foreach ($videos as $video) {
    echo "Video #{$video->id}: {$video->title}\n";
    echo "Course: {$video->module->course->title}\n";
    echo "URL: {$video->video_url}\n";

    // Extract video ID
    $videoId = null;

    // From embed format
    if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $video->video_url, $matches)) {
        $videoId = $matches[1];
        echo "✓ Format: EMBED (Correct)\n";
        $embedFormat++;
    }
    // From watch format
    elseif (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $video->video_url, $matches)) {
        $videoId = $matches[1];
        echo "✗ Format: WATCH (Wrong - needs conversion)\n";
        $watchFormat++;
    }
    // From youtu.be format
    elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $video->video_url, $matches)) {
        $videoId = $matches[1];
        echo "✗ Format: SHORT URL (Wrong - needs conversion)\n";
        $watchFormat++;
    }
    else {
        echo "⊗ Format: UNKNOWN or NOT YOUTUBE\n";
        $invalid++;
    }

    if ($videoId) {
        echo "Video ID: {$videoId}\n";

        // Track unique video IDs
        if (!isset($videoIds[$videoId])) {
            $videoIds[$videoId] = 0;
        }
        $videoIds[$videoId]++;

        // Test URL (we can't actually fetch it from CLI, but show the test URL)
        echo "Test in browser: https://www.youtube.com/watch?v={$videoId}\n";
        echo "Embed URL: https://www.youtube.com/embed/{$videoId}\n";
    }

    echo str_repeat("-", 80) . "\n";
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "SUMMARY:\n";
echo "  Total videos checked: " . count($videos) . "\n";
echo "  ✓ Correct embed format: {$embedFormat}\n";
echo "  ✗ Wrong format (watch/short): {$watchFormat}\n";
echo "  ⊗ Invalid/non-YouTube: {$invalid}\n";
echo "\nUNIQUE VIDEO IDs FOUND:\n";

arsort($videoIds);
$count = 0;
foreach ($videoIds as $id => $usage) {
    echo "  - {$id} (used {$usage} times)\n";
    $count++;
    if ($count >= 10) {
        echo "  ... and " . (count($videoIds) - 10) . " more\n";
        break;
    }
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "TROUBLESHOOTING:\n\n";

echo "If videos show 'Video tidak tersedia':\n\n";

echo "1. CHECK IF VIDEO IDs ARE VALID:\n";
echo "   Open these URLs in your browser to test:\n";
$count = 0;
foreach (array_keys($videoIds) as $id) {
    echo "   https://www.youtube.com/watch?v={$id}\n";
    $count++;
    if ($count >= 3) break;
}

echo "\n2. COMMON ISSUES:\n";
echo "   ✗ Video has been deleted by owner\n";
echo "   ✗ Video has embedding disabled (owner settings)\n";
echo "   ✗ Video is age-restricted (can't embed)\n";
echo "   ✗ Video is private or unlisted\n";
echo "   ✗ Video ID is invalid/fake\n";

echo "\n3. TEST WITH KNOWN-GOOD VIDEO:\n";
echo "   Try updating one video with this ID:\n";
echo "   - dQw4w9WgXcQ (Rick Astley - allows embedding)\n";
echo "   - M7lc1UVf-VE (Epic sax guy - allows embedding)\n";
echo "   - jNQXAC9IVRw (Me at the zoo - allows embedding)\n";

echo "\n4. UPDATE TEST VIDEO:\n";
echo "   Run this in MySQL or through Tinker:\n";
echo "   UPDATE videos SET video_url = 'https://www.youtube.com/embed/dQw4w9WgXcQ' WHERE id = 1;\n";

echo "\n5. CHECK BLADE TEMPLATE:\n";
echo "   Make sure learn.blade.php has:\n";
echo "   <iframe src=\"{{ \$currentVideo->video_url }}\" \n";
echo "           allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\"\n";
echo "           allowfullscreen></iframe>\n";

echo "\nDone!\n";

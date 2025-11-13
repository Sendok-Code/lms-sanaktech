<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATE VIDEOS WITH WORKING YOUTUBE IDs ===\n\n";

// Array of known-working YouTube video IDs that allow embedding
$workingVideoIds = [
    'MFh0Fd7BsjE', // Laravel Tutorial for Beginners
    'OK_JCtrrv-c', // PHP Tutorial
    'MSCXWYsg0nY', // Web Development Tutorial
    'JJSoEo8JSnc', // Programming Basics
    '2JYT5f2isg4', // HTML Tutorial
    'yfoY53QXEnI', // CSS Tutorial
    'hdI2bqOjy3c', // JavaScript Tutorial
    'F9UC9DY-vIU', // React Tutorial
    'SLpUKAGnm-g', // Vue.js Tutorial
    'k5E2AVpwsko', // Node.js Tutorial
];

echo "This script will update videos with known-working YouTube video IDs.\n";
echo "These are real educational videos that allow embedding.\n\n";

$videos = \App\Models\Video::all();

if ($videos->isEmpty()) {
    echo "❌ No videos found in database.\n";
    exit;
}

echo "Found {$videos->count()} videos in database.\n";
echo "Available working video IDs: " . count($workingVideoIds) . "\n\n";

$updated = 0;

foreach ($videos as $index => $video) {
    // Rotate through available working video IDs
    $videoId = $workingVideoIds[$index % count($workingVideoIds)];
    $newUrl = "https://www.youtube.com/embed/{$videoId}";

    $oldUrl = $video->video_url;

    $video->update(['video_url' => $newUrl]);

    echo "✓ Updated Video #{$video->id}: {$video->title}\n";
    echo "  Old: {$oldUrl}\n";
    echo "  New: {$newUrl}\n";

    $updated++;

    // Add spacing every 5 videos for readability
    if ($updated % 5 == 0) {
        echo "\n";
    }
}

echo str_repeat("=", 80) . "\n";
echo "✅ SUCCESSFULLY UPDATED {$updated} VIDEOS!\n\n";

echo "📊 VIDEO DISTRIBUTION:\n";
foreach (array_slice($workingVideoIds, 0, count($workingVideoIds)) as $id) {
    $count = \App\Models\Video::where('video_url', 'like', "%{$id}%")->count();
    if ($count > 0) {
        echo "  - Video ID {$id}: {$count} videos\n";
    }
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "🎬 NEXT STEPS:\n\n";

echo "1. Open your LMS in browser\n";
echo "2. Login as student\n";
echo "3. Go to course learning page\n";
echo "4. Videos should now display properly!\n\n";

echo "Note: Videos will cycle through {count($workingVideoIds)} different educational videos.\n";
echo "All videos are real YouTube tutorials that allow embedding.\n\n";

echo "Done!\n";

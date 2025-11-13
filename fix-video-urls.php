<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIX VIDEO URLS TO EMBED FORMAT ===\n\n";

$videos = \App\Models\Video::all();

$fixed = 0;
$skipped = 0;

foreach ($videos as $video) {
    $originalUrl = $video->video_url;

    // Check if YouTube URL and not embed format
    if ((strpos($originalUrl, 'youtube.com') !== false || strpos($originalUrl, 'youtu.be') !== false)
        && strpos($originalUrl, '/embed/') === false) {

        // Extract video ID
        $videoId = null;

        // From youtube.com/watch?v=ID
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $originalUrl, $matches)) {
            $videoId = $matches[1];
        }
        // From youtu.be/ID
        elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $originalUrl, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            $newUrl = "https://www.youtube.com/embed/{$videoId}";

            // Update video URL
            $video->update(['video_url' => $newUrl]);

            echo "✓ Fixed Video #{$video->id}: {$video->title}\n";
            echo "  Old: {$originalUrl}\n";
            echo "  New: {$newUrl}\n\n";

            $fixed++;
        } else {
            echo "⊗ Could not extract ID from: {$originalUrl}\n\n";
            $skipped++;
        }
    } elseif (strpos($originalUrl, '/embed/') !== false) {
        echo "- Video #{$video->id} already in embed format\n\n";
        $skipped++;
    } else {
        echo "- Video #{$video->id} not YouTube URL: {$originalUrl}\n\n";
        $skipped++;
    }
}

echo str_repeat("=", 80) . "\n";
echo "Summary:\n";
echo "  Fixed: {$fixed}\n";
echo "  Skipped: {$skipped}\n";
echo "  Total: " . ($fixed + $skipped) . "\n";
echo "\nDone! All YouTube URLs converted to embed format.\n";

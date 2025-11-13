<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECK VIDEO URLS ===\n\n";

$videos = \App\Models\Video::with('module.course')->take(10)->get();

if ($videos->isEmpty()) {
    echo "No videos found in database.\n";
    exit;
}

foreach ($videos as $video) {
    echo "Video ID: {$video->id}\n";
    echo "Title: {$video->title}\n";
    echo "Course: {$video->module->course->title}\n";
    echo "URL: {$video->video_url}\n";

    // Check if URL is YouTube
    if (strpos($video->video_url, 'youtube.com') !== false || strpos($video->video_url, 'youtu.be') !== false) {
        echo "Type: YouTube\n";

        // Check if embed format
        if (strpos($video->video_url, '/embed/') !== false) {
            echo "Format: ✓ Embed (OK)\n";
        } else {
            echo "Format: ✗ Watch URL (Need to convert to embed)\n";

            // Convert to embed URL
            $videoId = null;
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video->video_url, $matches)) {
                $videoId = $matches[1];
                $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                echo "Should be: {$embedUrl}\n";
            }
        }
    } else {
        echo "Type: Other/Direct URL\n";
    }

    echo str_repeat("-", 80) . "\n";
}

echo "\nDone!\n";

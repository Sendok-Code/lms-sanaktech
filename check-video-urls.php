<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$videos = App\Models\Video::all(['id', 'title', 'video_url']);

echo "=== VIDEO URLs IN DATABASE ===\n\n";
foreach($videos as $video) {
    echo "ID: {$video->id}\n";
    echo "Title: {$video->title}\n";
    echo "URL: {$video->video_url}\n";
    echo str_repeat('-', 50) . "\n";
}
echo "\nTotal: " . $videos->count() . " videos\n";

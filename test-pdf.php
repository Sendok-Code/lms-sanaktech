<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test Setting::get()
$ceoName = App\Models\Setting::get('ceo_name', 'DEFAULT CEO');
$platformName = App\Models\Setting::get('platform_name', 'DEFAULT PLATFORM');

echo "CEO Name from Setting::get(): " . $ceoName . "\n";
echo "Platform Name from Setting::get(): " . $platformName . "\n";

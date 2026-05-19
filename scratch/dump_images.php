<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Bootstrap Laravel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Product::all() as $product) {
    echo "ID: {$product->id}, Name: {$product->name}, Main Image: " . var_export($product->main_image, true) . "\n";
}

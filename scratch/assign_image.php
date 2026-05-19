<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Bootstrap Laravel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$product = App\Models\Product::find(1);
if ($product) {
    $product->main_image = 'products/media__1779016963522.png';
    $product->save();
    echo "Success: Main image updated successfully to 'products/media__1779016963522.png'!\n";
} else {
    echo "Error: Product 1 not found.\n";
}

<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$user = App\Models\User::where('email', 'admin@example.com')->first();
if ($user) {
    echo "FOUND: " . $user->email . PHP_EOL;
} else {
    echo "NOT FOUND" . PHP_EOL;
}

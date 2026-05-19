<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$u = User::factory()->create();
echo 'user created: ' . $u->email . PHP_EOL;
echo 'hash_check: ' . (Hash::check('password', $u->password) ? 'true' : 'false') . PHP_EOL;
echo 'attempt: ' . (Auth::attempt(['email' => $u->email, 'password' => 'password']) ? 'true' : 'false') . PHP_EOL;

?>

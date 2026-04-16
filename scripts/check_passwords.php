<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;

$users = \App\Models\User::all();
foreach ($users as $u) {
    $ok1234 = Hash::check('1234', $u->password) ? 'yes' : 'no';
    $ok12345 = Hash::check('12345', $u->password) ? 'yes' : 'no';
    echo $u->name . ": 1234? $ok1234, 12345? $ok12345\n";
}


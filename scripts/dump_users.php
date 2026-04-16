<?php
// Quick helper to dump users (name, email, role) as JSON
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = \App\Models\User::get(['name','email', 'role'])->toArray();
echo json_encode($users, JSON_PRETTY_PRINT) . PHP_EOL;


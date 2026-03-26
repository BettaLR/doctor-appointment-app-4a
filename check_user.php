<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'alexcanolara818@gmail.com')->first();

if ($user) {
    echo "User found: " . $user->name . " - " . $user->email . "\n";
    echo "Password hash: " . $user->password . "\n";
    echo "Email verified at: " . $user->email_verified_at . "\n";
    echo "Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
} else {
    echo "User not found.\n";
}

<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$response = $kernel->handle($request = \Illuminate\Http\Request::capture());

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

try {
    Mail::to('test@example.com')->send(new TestMail(['name' => 'Test User']));
    echo "✅ Test email sent successfully to Mailtrap!\n";
} catch (\Exception $e) {
    echo "❌ Error sending email: " . $e->getMessage() . "\n";
}

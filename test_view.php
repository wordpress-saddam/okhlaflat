<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$user = App\Models\User::role('customer')->first();
if (!$user) die("no user");

$request = Illuminate\Http\Request::create('/customer/properties/create', 'GET');
$request->setUserResolver(fn() => $user);

$response = $kernel->handle($request);
if ($response->getStatusCode() !== 200) {
    echo "ERROR: " . $response->getStatusCode() . "\n";
    echo substr($response->getContent(), 0, 1000);
} else {
    echo "View loads perfectly!";
}

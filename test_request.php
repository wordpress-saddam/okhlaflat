<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/customer/properties/step', 'POST', [
    'step' => 1,
    'title' => 'My flat',
    'locality_id' => 1,
    'property_type' => 'flat',
    'bhk' => 2
]);
$request->headers->set('Accept', 'application/json');

$response = $kernel->handle($request);
echo $response->getContent();

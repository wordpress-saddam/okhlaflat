<?php

$file = 'resources/views/customer/properties/create.blade.php';
$content = file_get_contents($file);

// Replace in Step 1
$content = preg_replace_callback('/(x-show="currentStep === 1".*?)(<!-- STEP 2)/s', function($matches) {
    return str_replace(' required class=', ' :required="currentStep === 1" class=', $matches[0]);
}, $content);

// Replace in Step 2
$content = preg_replace_callback('/(x-show="currentStep === 2".*?)(<!-- STEP 3)/s', function($matches) {
    return str_replace(' required min="0" class=', ' :required="currentStep === 2" min="0" class=', $matches[0]);
}, $content);

$content = preg_replace_callback('/(x-show="currentStep === 2".*?)(<!-- STEP 3)/s', function($matches) {
    return str_replace(' required min="1" class=', ' :required="currentStep === 2" min="1" class=', $matches[0]);
}, $content);

$content = preg_replace_callback('/(x-show="currentStep === 2".*?)(<!-- STEP 3)/s', function($matches) {
    return str_replace(' required class=', ' :required="currentStep === 2" class=', $matches[0]);
}, $content);

// Replace in Step 3
$content = preg_replace_callback('/(x-show="currentStep === 3".*?)(<!-- STEP 4)/s', function($matches) {
    return str_replace(' required class=', ' :required="currentStep === 3" class=', $matches[0]);
}, $content);

$content = preg_replace_callback('/(x-show="currentStep === 3".*?)(<!-- STEP 4)/s', function($matches) {
    return str_replace(' required rows="2" class=', ' :required="currentStep === 3" rows="2" class=', $matches[0]);
}, $content);

file_put_contents($file, $content);
echo "Fixed required attributes.\n";


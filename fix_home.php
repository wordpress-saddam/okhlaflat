<?php
$file = 'resources/views/home.blade.php';
$content = file_get_contents($file);
$content = str_replace('flat 25% service fee', 'flat {{ $globalBrokerageFee }}% service fee', $content);
$content = str_replace('The 25% Service Fee Model', 'The {{ $globalBrokerageFee }}% Service Fee Model', $content);
$content = str_replace('only 25% of one month\'s rent', 'only {{ $globalBrokerageFee }}% of one month\'s rent', $content);
$content = str_replace('OkhlaFlat Service Fee (25%)', 'OkhlaFlat Service Fee ({{ $globalBrokerageFee }}%)', $content);
$content = str_replace('₹4,000', '₹{{ number_format(16000 * ($globalBrokerageFee / 100)) }}', $content);
$content = preg_replace('/₹12,000 Saved!/', '₹{{ number_format(16000 - (16000 * ($globalBrokerageFee / 100))) }} Saved!', $content);
file_put_contents($file, $content);

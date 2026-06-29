<?php
$file = 'resources/views/agent/deals/close.blade.php';
$content = file_get_contents($file);
$content = str_replace('25% of this amount', '{{ $globalBrokerageFee }}% of this amount', $content);
file_put_contents($file, $content);

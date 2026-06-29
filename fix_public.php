<?php
$file = 'resources/views/layouts/public.blade.php';
$content = file_get_contents($file);
$content = str_replace('25% service fee', '{{ $globalBrokerageFee }}% service fee', $content);
file_put_contents($file, $content);

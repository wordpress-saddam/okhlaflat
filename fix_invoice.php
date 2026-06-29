<?php
$file = 'resources/views/agent/deals/invoice.blade.php';
$content = file_get_contents($file);
$content = str_replace('<span class="font-bold text-slate-900 block">OkhlaFlat Assistance Service Fee</span>', '<span class="font-bold text-slate-900 block">OkhlaFlat Assistance Service Fee ({{ $globalBrokerageFee }}%)</span>', $content);
file_put_contents($file, $content);

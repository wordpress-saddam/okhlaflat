<?php
$file = 'tests/Feature/PlatformSettingsTest.php';
$content = file_get_contents($file);
$content = str_replace("User::factory()->create(['role' => 'admin'])", "User::factory()->create()->assignRole('admin')", $content);
$content = str_replace("User::factory()->create(['role' => 'agent'])", "User::factory()->create()->assignRole('agent')", $content);
file_put_contents($file, $content);

<?php
$file = 'tests/Feature/ExampleTest.php';
$content = file_get_contents($file);
$content = str_replace('// use Illuminate\Foundation\Testing\RefreshDatabase;', 'use Illuminate\Foundation\Testing\RefreshDatabase;', $content);
$content = str_replace('class ExampleTest extends TestCase', "class ExampleTest extends TestCase\n{\n    use RefreshDatabase;", $content);
$content = preg_replace('/\{\n\s+use RefreshDatabase;\n\s+\{/', "{\n    use RefreshDatabase;", $content);
file_put_contents($file, $content);

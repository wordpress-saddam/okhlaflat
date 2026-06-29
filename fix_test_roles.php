<?php
$file = 'tests/Feature/PlatformSettingsTest.php';
$content = file_get_contents($file);
$content = str_replace('use App\Models\Setting;', "use App\Models\Setting;\nuse Spatie\Permission\Models\Role;", $content);

$setup = <<<PHP
    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'agent']);
        Role::create(['name' => 'customer']);
    }
PHP;
$content = str_replace('use RefreshDatabase;', "use RefreshDatabase;\n\n{$setup}", $content);
file_put_contents($file, $content);

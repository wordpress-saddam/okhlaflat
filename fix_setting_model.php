<?php
$file = 'app/Models/Setting.php';
$content = file_get_contents($file);
$content = str_replace(
    'return $setting ? $setting->value : $default;',
    "return \$setting ? \$setting->value : \$default;\n        } catch (\\Illuminate\\Database\\QueryException \$e) {\n            return \$default;",
    $content
);
$content = str_replace(
    'return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {',
    "return Cache::rememberForever(\"setting_{\$key}\", function () use (\$key, \$default) {\n            try {",
    $content
);
$content = preg_replace('/\}\);(\s+)\}/', "}\n        });\n    }", $content);
file_put_contents($file, $content);

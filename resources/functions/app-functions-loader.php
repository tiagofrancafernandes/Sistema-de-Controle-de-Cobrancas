<?php

$functionFiles = [
    __DIR__ . '/custom-laravel-helpers.php',
];

foreach ($functionFiles as $filePath) {
    require $filePath;
}

unset($functionFiles);

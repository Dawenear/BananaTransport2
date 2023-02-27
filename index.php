<?php

require("vendor/autoload.php");

if (!$argv[1]) {
    echo 'Path for file not provided' . PHP_EOL;
    exit();
}
if (!is_file($argv[1])) {
    echo 'File not exists' . PHP_EOL;
    exit();
}
if (!$notes = file_get_contents($argv[1])){
    echo 'Unable to load file' . PHP_EOL;
    exit();
}

try {
    $handler = new App\Controllers\ProcessDelivery();
    $handler->registerAlgorithm('\\App\\Models\\FirstAlgorithm');
    $handler->registerAlgorithm('\App\Models\SecondAlgorithm');
    echo $handler->handleRoute($notes);
} catch (Exception $e) {
    echo $e->getMessage();
}

echo PHP_EOL;

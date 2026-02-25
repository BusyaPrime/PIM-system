<?php

require __DIR__.'/vendor/autoload.php';

use App\Kernel;

try {
    $kernel = new Kernel('dev', true);
    $kernel->boot();
    echo "Boot successful.\n";
} catch (\Throwable $e) {
    file_put_contents(__DIR__.'/error_dump.txt', $e->getMessage() . "\n" . $e->getFile() . ":" . $e->getLine());
    echo "Dumped to error_dump.txt\n";
}

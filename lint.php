<?php

$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/app'));
$errors = 0;
$count = 0;

foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $count++;
        $out = [];
        $ret = 0;
        exec('php -l "' . $file->getPathname() . '"', $out, $ret);
        if ($ret !== 0) {
            echo "SYNTAX ERROR in " . $file->getPathname() . ": " . implode("\n", $out) . "\n";
            $errors++;
        }
    }
}

echo "Linted $count PHP files in app/ directory. Errors: $errors\n";
if ($errors === 0) {
    echo "SUCCESS: All files are syntactically valid!\n";
}

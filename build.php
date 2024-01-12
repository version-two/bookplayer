<?php
$versionTag = '-dev-';
$minify     = false;

foreach ($argv as $arg) {
    if (strpos($arg, '--version') !== false) {
        list(, $versionTag) = explode('=', $arg);
    } elseif ($arg === '--minify') {
        $minify = true;
    }
}

$fileContents = file_get_contents('src/php_and_html.php');
// Searching for pattern
preg_match_all('/\/\*include::(.+?)\*\//', $fileContents, $matches);

if (isset($matches[1])) {
    foreach ($matches[1] as $filename) {
        // Reading the included file
        $includedContents = file_get_contents('./src/' . $filename);
        if ($includedContents === false) {
            die("Couldn't read file: ./src/{$filename}");
        }
        // Replacing the pattern with actual content
        $fileContents = str_replace("/*include::{$filename}*/", $includedContents, $fileContents);
    }
}

if ($minify) {
    // Simulating minify function, this won't work for all cases as PHP file minification is bit complex
    // you might want to find in Internet or use libraries
    $fileContents = preg_replace("/(\s|^)\/\/(.*?)(\r?\n|$)/", '$1/*$2*/', $fileContents);
    $fileContents = preg_replace('/\s+/', ' ', $fileContents);
}

$fileContents = str_replace('{version}', $versionTag, $fileContents);
// Writing to /dist/index.php
$result = file_put_contents('./dist/index.php', $fileContents);
if ($result === false) {
    die('Failed to write file: ./dist/index.php');
}

echo "Operation completed successfully!\n";
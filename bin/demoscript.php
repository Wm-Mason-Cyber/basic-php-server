#!/usr/bin/env php
<?php
/**
 * demoscript.php
 *
 * A tiny CLI script that demonstrates reading input, sanitizing, and printing
 * HTML-escaped output. This file is for classroom demonstration and is not
 * intended for production use.
 */

require_once __DIR__ . '/../src/helpers.php';

// Read a value from argv or prompt the user
$input = $argv[1] ?? null;
if ($input === null) {
    echo "Enter a test string: ";
    $input = rtrim(fgets(STDIN), "\n");
}

$san = sanitize_text($input);
$escaped = html_escape($san);

echo "Original:    {$input}\n";
echo "Sanitized:   {$san}\n";
echo "Escaped HTML: {$escaped}\n";

// Exit code 0 for success
exit(0);

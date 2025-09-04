<?php
/**
 * helpers.php
 *
 * A small collection of helper functions used by the demo site and CLI tools.
 * These are intentionally simple and heavily commented for classroom reading.
 */

/**
 * Escape a string for safe HTML output.
 * Wrapper around htmlspecialchars with safe defaults.
 *
 * @param string $s
 * @return string
 */
function html_escape(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * A very small sanitizer for text inputs used in demonstrations.
 * It trims and collapses multiple whitespace chars and removes control
 * characters to keep examples predictable.
 *
 * @param string $s
 * @return string
 */
function sanitize_text(string $s): string
{
    // Trim and normalize whitespace
    $s = trim($s);
    $s = preg_replace('/\s+/u', ' ', $s);
    // Remove ASCII control characters except newline/tab
    $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $s);
    return $s;
}

/**
 * Simple URL validator used in examples (not a replacement for robust libs).
 *
 * @param string $url
 * @return bool
 */
function is_valid_url(string $url): bool
{
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

// End of helpers.php

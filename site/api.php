<?php
// Simple API endpoint used for classroom examples.
require_once __DIR__ . '/../src/helpers.php';

header('Content-Type: application/json; charset=utf-8');

$q = $_GET['q'] ?? null;
if ($q !== null) {
    $q = sanitize_text($q);
}

$resp = [
    'ok' => true,
    'query' => $q,
    'safe' => html_escape((string)$q),
];

echo json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

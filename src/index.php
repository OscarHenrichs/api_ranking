<?php

try {
    require_once __DIR__ . "/api/server.php";
} catch (Throwable $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => 'Internal Server Error',
        'message' => $e->getMessage(),
        'trace' => $e->getTrace() // Only in development!
    ]);
    exit;
}

<?php

try {
    require_once __DIR__ . "/config/bootstrap.php";
    require_once __DIR__ . "/config/http.php";
} catch (Throwable $e) {
    die("Fatal Error: " . $e->getMessage());
}

use Api\Routes\Router\Router;

try {
    $router = new Router();
    $router->route();
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

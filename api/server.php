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

// try {
//     $url = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '') : '';
//     $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

//     if (empty($url)) {
//         header("HTTP/1.1 404 Not Found");
//         echo json_encode(['message' => 'Welcome to the API. Please specify an endpoint.' . $url]);
//         exit;
//     }

//     switch ($url) {
//         case 'users':

//             header("Content-Type: application/json");
//             http_response_code(200);
//             echo json_encode(['message' => 'Users endpoint']);
//             break;

//         default:
//             header("HTTP/1.1 404 Not Found");
//             echo json_encode(['message' => 'Endpoint not found url:' . $url]);
//     }

//     exit;
// } catch (Throwable $e) {
//     header('Content-Type: application/json');
//     http_response_code(500);
//     echo json_encode([
//         'error' => 'Internal Server Error',
//         'message' => $e->getMessage(),
//         'trace' => $e->getTrace() // Only in development!
//     ]);
//     exit;
// }


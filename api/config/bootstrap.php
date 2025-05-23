<?php
define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

try {
    include ROOT_PATH . '/config/database.php';
} catch (Exception $e) {

    echo json_encode(['error' => 'Failed to load Database: ' . $e->getMessage()]);
    exit;
}
try {
    require_once ROOT_PATH . '/models/userModel.php';
} catch (Exception $e) {

    echo json_encode(['error' => 'Failed to load Models: ' . $e->getMessage()]);
    exit;
}
try {
    require_once ROOT_PATH . '/controllers/userController.php';
} catch (Exception $e) {

    echo json_encode(['error' => 'Failed to load controllers: ' . $e->getMessage()]);
    exit;
}
try {
    require_once ROOT_PATH . '/routes/router.php';
    require_once ROOT_PATH . '/routes/rankingRoute.php';

} catch (Exception $e) {

    echo json_encode(['error' => 'Failed to load router: ' . $e->getMessage()]);
    exit;
}
try {
    require_once ROOT_PATH . '/config/http.php';
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to load HTTP configuration: ' . $e->getMessage()]);
    exit;
}

try {
    require_once ROOT_PATH . '/tools/sanitizeParameters.php';
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to load Tools' . $e->getMessage()]);
    exit;
}
?>
<?php
use Api\Routes\UserRoute\UserRoute;
switch ($url) {
    case 'user':
        UserRoute::switchRoute($url, $requestMethod);
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['message' => 'Endpoint not found']);
        break;
}

?>
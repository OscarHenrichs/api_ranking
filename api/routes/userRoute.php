<?php
namespace Api\Routes\UserRoute;

use Api\Controllers\UserController\UserController;
class UserRoute
{
    public static function switchRoute($path, $requestMethod)
    {
        $controller = new UserController();
        $routes = explode($path, '/') ?: '/';
        if (count($routes) > 1 && $routes[1] !== '') {
            $url = $routes[1];
        } else {
            $url = '';
        }
        switch ($url) {
            case '':
                $controller = new UserController();
                switch ($requestMethod) {
                    case 'GET':
                        $controller->getAllItems();
                        break;
                    default:
                        header("HTTP/1.1 405 Method Not Allowed");
                        echo json_encode(['message' => 'Method not allowed']);
                        break;
                }
                break;
            case preg_match('/([0-9]+)$/', $path, $matches) ? true : false:
                switch ($requestMethod) {
                    default:
                        header("HTTP/1.1 405 Method Not Allowed");
                        echo json_encode(['message' => 'Method not allowed']);
                        break;
                }
                break;
            default:
                header("HTTP/1.1 404 Not Found");
                echo json_encode(['message' => 'Endpoint not found']);
                break;
        }
    }
}
?>
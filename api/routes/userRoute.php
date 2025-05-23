<?php
namespace Api\Routes\UserRoute;

use Api\Controllers\UserController\UserController;
class UserRoute
{
    public static function switchRoute($url, $requestMethod)
    {
        $controller = new UserController();
        $matches = [];
        $url = trim($url, '/');

        // Check if the URL matches the pattern


        switch ($url) {
            case '':
                $controller = new UserController();
                $id = $matches[1];
                switch ($requestMethod) {
                    case 'GET':
                        $controller->getItem($id);
                        break;
                    case 'PUT':
                        $controller->updateItem($id);
                        break;
                    case 'DELETE':
                        $controller->deleteItem($id);
                        break;
                    default:
                        header("HTTP/1.1 405 Method Not Allowed");
                        echo json_encode(['message' => 'Method not allowed']);
                        break;
                }
                break;
            case preg_match('/([0-9]+)$/', $url, $matches) ? true : false:

                switch ($requestMethod) {
                    case 'GET':
                        $controller->getAllItems();
                        break;
                    case 'POST':
                        $controller->createItem();
                        break;
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
<?php
namespace Api\Routes\Router;
use Api\Routes\UserRoute\UserRoute;

class Router
{
    private $requestPath;
    private $requestRoute;
    private $requestMethod;

    // Initialize routes when needed, not during property declaration
    private $routes;

    public function __construct()
    {
        $this->routes = [
            'users' => UserRoute::class
        ];
    }

    public function route()
    {
        $this->getCurrentRoute();
        $this->getRequestMethod();

        if (empty($this->requestRoute)) {
            $this->sendResponse(404, ['message' => 'Welcome to the API. Please specify an endpoint.']);
            return;
        }

        $route = trim($this->requestRoute[0], '/');

        switch ($route) {
            case 'belezinha':
                $this->sendResponse(200, ['message' => 'Belezinha']);
                break;
            case 'users':
                UserRoute::switchRoute($this->requestPath, $this->requestMethod);
                break;
            case 'teste':
                $this->sendResponse(code: 200, data: ['message' => 'Endpoint teste found: ' . $this->requestPath . " " . $route]);
                break;
            default:
                $this->sendResponse(code: 404, data: ['message' => 'Endpoint not found:' . $this->requestPath . " " . $route]);
        }
    }

    private function getRequestMethod()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    private function getCurrentRoute()
    {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->requestPath = trim($path, '/');
        $this->requestRoute = explode('/', $this->requestPath) ?: '/';
    }

    private function sendResponse($code, $data)
    {
        header("Content-Type: application/json");
        http_response_code($code);
        echo json_encode($data);
        exit;
    }
}
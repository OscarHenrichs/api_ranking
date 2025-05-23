<?php
namespace Api\Routes\Router;
use Api\Routes\RankingRoute\RankingRoute;

class Router
{
    private $requestPath;
    private $requestRoute;
    private $requestParams;
    private $requestBody;
    private $requestMethod;

    // Initialize routes when needed, not during property declaration
    private $routes;

    public function __construct()
    {
        $this->routes = [
            'ranking' => RankingRoute::class
        ];
    }

    public function route()
    {
        $this->getCurrentRoute();
        $this->getRequestParams();
        $this->getRequestBody();
        $this->getRequestMethod();

        if (empty($this->requestRoute)) {
            $this->sendResponse(404, ['message' => 'Welcome to the API. Please specify an endpoint.']);
            return;
        }

        $route = trim($this->requestRoute[0], '/');

        switch ($route) {
            case 'ranking':
                RankingRoute::switchRoute($this->requestMethod, $this->requestPath, $this->requestParams, $this->requestBody);
                break;
            default:
                $this->sendResponse(code: 404, data: ['message' => 'Endpoint not found:' . $this->requestPath . " " . $route]);
        }
    }

    private function getRequestMethod()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }


    private function getRequestParams(): void
    {
        $queryString = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY);

        if ($queryString === null) {
            $this->requestParams = [];
            return;
        }

        parse_str($queryString, $this->requestParams);
    }

    private function getRequestBody()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            return;
        }
        if (empty($_SERVER['CONTENT_TYPE']) || strpos($_SERVER['CONTENT_TYPE'], 'application/json') === false) {
            throw new \Exception("Invalid Content-Type: " . $_SERVER['CONTENT_TYPE']);
        }
        if (empty(file_get_contents('php://input'))) {
            throw new \Exception("Empty request body");
        }
        $this->requestBody = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid JSON: " . json_last_error_msg());
        }
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
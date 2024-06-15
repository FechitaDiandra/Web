<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Router {
    private $routes;
    private static $instance = null;

    public function __construct() {
        $this->routes = [];
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function addRoute($method, $pattern, $callback) {
        $this->routes[] = ['method' => $method, 'pattern' => $pattern, 'callback' => $callback];
    }

    public function route() {
        $requestPath = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $basePath = '/web/proiect/app';
        $path = strtolower(str_replace($basePath, '', strtok($requestPath, '?')));

        error_log("Request Path: " . $path);

        foreach ($this->routes as $route) {
            if ($method == $route['method'] && preg_match($route['pattern'], $path, $matches)) {
                array_shift($matches);
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}
?>

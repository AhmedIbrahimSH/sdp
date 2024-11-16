<?php


class Router
{
    private $routes = [];

    public function get($route, $callback)
    {
        $this->routes['GET'][$route] = $callback;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            $callback = $this->routes[$method][$uri];
            if (is_callable($callback)) {
                call_user_func($callback);
            } elseif (is_string($callback)) {
                [$controller, $method] = explode('@', $callback);
                require_once "controllers/{$controller}.php";
                $controller = new $controller();
                $controller->$method();
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }

}
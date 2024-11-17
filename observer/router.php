<?php

class Router {
    private $routes = [];

    // Method to define a route
    public function addRoute($path, $callback) {
        $this->routes[$path] = $callback;
    }

    // Method to handle the current request
    public function handleRequest() {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (array_key_exists($requestUri, $this->routes)) {
            call_user_func($this->routes[$requestUri]);
        } else {
            $this->display404();
        }
    }

    // Method to display a 404 error
    private function display404() {
        http_response_code(404);
        echo "404 Not Found";
    }
}

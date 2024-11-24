<?php
require_once 'Router.php';

// Instantiate the Router
$router = new Router();

// Define routes and their corresponding callbacks
$router->addRoute('/', function () {
    include 'view/notification-view.php';
});

// $router->addRoute('/about', function () {
//     include 'views/about.php';
// });

// Handle the current request
$router->handleRequest();

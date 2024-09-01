<?php

require_once './vendor/autoload.php';
require_once './Routes/routes.php';

$requestUri = $_SERVER['REQUEST_URI'];
$parts = explode('/', trim($requestUri, '/'));

session_start();

// Match route
$matchedRoute = null;
$parameters = [];

foreach ($routes as $route => $handler) {
    $routeParts = explode('/', trim($route, '/'));

    if (count($routeParts) === count($parts)) {
        $match = true;
        foreach ($routeParts as $index => $part) {
            if (strpos($part, '{') === 0 && strpos($part, '}') === (strlen($part) - 1)) {
                // This is a dynamic parameter, save it
                $parameters[] = $parts[$index];
            } elseif ($part !== $parts[$index]) {
                $match = false;
                break;
            }
        }

        if ($match) {
            $matchedRoute = $handler;
            break;
        }
    }
}

// If a matching route is found, call the corresponding controller and method
if ($matchedRoute) {
    $controllerName = $matchedRoute[0];
    $method = $matchedRoute[1];

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $parameters); // Pass parameters to method
        } else {
            http_response_code(404);
            echo '404 Method Not Found';
        }
    } else {
        http_response_code(404);
        echo '404 Controller Not Found';
    }
} else {
    http_response_code(404);
    echo '404 Route Not Found';
}

<?php

namespace App\Core;

use RuntimeException;

class Router
{

    /**
     * All the registered routes.
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Load the file containg all the routes.
     * @param $file
     * @return Router
     */
    public static function load($file): Router
    {
        $router = new static;

        require $file;

        return $router;
    }

    /**
     * Register a get route.
     * @param $uri
     * @param $controller
     */
    public function get($uri, $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }


    /**
     * Load the controller's method associated with the URI
     * @param $uri
     * @param $requestType
     * @return mixed
     */
    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        throw new RuntimeException('No route defined for this URI.');
    }


    /**
     * Load the controller and call it's action.
     * @param $controller
     * @param $action
     * @return mixed
     */
    protected function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";


        if (!method_exists($controller, $action)) {
            throw new RuntimeException(
                "{$controller} does not respond to the {$action} action."
            );
        }

        $controller = new $controller;
        return $controller->$action();
    }
}

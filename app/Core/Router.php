<?php
namespace App\Core;
use App\Controllers\Controller;
use Exception;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function put($uri, $controller)
    {
        $this->routes['PUT'][$uri] = $controller;
    }

    public function delete($uri, $controller)
    {
        $this->routes['DELETE'][$uri] = $controller;
    }

    public function direct($params, $requestType)
    {
        if(array_key_exists($params['path'] , $this->routes[$requestType])) {

            return $this->callAction(
                $params['model'],
                $params['arguments'],
                explode("@", $this->routes[$requestType][$params['path']])[0],
                $params['action']
            );
        }

        throw new Exception('No route defined for this URI.');
    }

    protected function callAction($model, $arguments, $controller, $action)
    {
        if(!method_exists($controller, $action)) {
            throw new Exception(
                "$controller does not respond to the $action action."
            );
        }
        return (new $controller($model))->$action($arguments);
    }
}

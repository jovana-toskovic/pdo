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

    private $url = ['/', 'index', ''];
    private $arguments = [];
    private $path = 'index';

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

    public function direct($uri, $requestType)
    {

        $urlArray = explode('/', $uri);

        if($requestType === 'GET') {
            array_splice( $urlArray, 1, 0, 'index');
            if(count($urlArray) > 2) {
                $this->arguments = ['id' => $urlArray[1]];
            }
        }

        $this->path = "$urlArray[0]/$urlArray[1]";


        if($requestType === 'PUT') {
            parse_str(file_get_contents("php://input"), $_PUT);
            $_REQUEST = array_merge($_REQUEST, $_PUT);
            $this->arguments = $_REQUEST;
            if ($urlArray[2] !== $this->arguments['id']) {
                throw new Exception('Id does not match.');
            }
        }

        if($requestType === 'POST') {
            $this->arguments = $_POST;
        }

        if($requestType === 'DELETE') {
            $this->arguments = ['id' => $urlArray[2]];
        }

        if(array_key_exists($this->path , $this->routes[$requestType])) {

            return $this->callAction(
                ...explode("@", $this->routes[$requestType][$this->path])
            );
        }

        throw new Exception('No route defined for this URI.');
    }


    protected function callAction($controller, $action)
    {
        if(!method_exists($controller, $action)) {
            throw new Exception(
                "$controller does not respond to the $action action."
            );
        }
        var_dump($this->url[2]);
        return (new $controller())->$action($this->arguments);
    }
}

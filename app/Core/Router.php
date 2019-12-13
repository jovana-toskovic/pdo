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
        var_dump($uri, $_GET);

        if($requestType === 'GET') {
            $urlArray = explode('/', $uri);

            if(count($urlArray) > 1) {
                $this->arguments = ['id' => $urlArray[1]];
            }
            $this->path = "$urlArray[0].$this->path";
        }

        if($requestType === 'PUT') {

            parse_str(file_get_contents("php://input"), $_PUT);

            foreach ($_PUT as $key => $value)
            {
                unset($_PUT[$key]);

                $_PUT[str_replace('amp;', '', $key)] = $value;
            }

            $_REQUEST = array_merge($_REQUEST, $_PUT);
            var_dump($_PUT);
            die("This is PUT request");
        }




//        $this->url[0] = $urlArray[0];
//
//        if(count($urlArray) === 2 ) {
//            $this->url[2] = $urlArray[1];
//        } elseif (count($urlArray) > 2) {
//
//            $this->url[1] = $urlArray[1];
//            $this->url[2] = $urlArray[2];
//        }
//
//        if($this->url[2] !== '' && $this->url[2]{0} !== '?') {
//            $this->url[2] = "id=" . $this->url[2];
//
//            $arguments = [];
//            foreach(preg_split("/[&]+/", $this->url[2]) as $keyValueArray) {
//                $array = preg_split("/[=]+/", htmlspecialchars($keyValueArray));
//                $arguments[$array[0]] = $array[1];
//            }
//            $this->url[2] = $arguments;
//
//            // ? id= 1&name=Anna
//            // myresources?field1=x&field2=y&inclusive=true
//
//        }
//
//
//
//        $path = $this->url[0] . "." . $this->url[1];

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

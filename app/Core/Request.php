<?php

namespace App\Core;
use Exception;

class Request
{
    private $requestType;

    private function request($urlArray)
    {
        $request = [];
        $action = $urlArray[1] ? $urlArray[1] : 'index';

        if($this->requestType === 'GET' || $this->requestType === 'DELETE') {
            if($this->requestType === 'GET' && count($urlArray) < 2) {
                array_splice( $urlArray, 1, 0, 'index');
            }
            $request = array_key_exists(2, $urlArray) ? ['id' => $urlArray[2]] : [];
            if($urlArray[1] === 'edit') {
                $action = 'update';
            }
            if($urlArray[1] === 'create') {
                $action = 'store';
            }
        }

        if($this->requestType === 'PUT') {
            parse_str(file_get_contents("php://input"), $_PUT);
            $request = $_PUT;

        }

        if($this->requestType === 'POST') {
            $request = $_POST;
        }

        $model = $urlArray[0];
        $path = "$urlArray[0]/$urlArray[1]";
        return ['path' => $path, 'arguments' => $request, 'model' => $model, 'action'=>$action];
    }

    public function uri()
    {
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $urlArray = explode('/', $uri);

       return $this->request($urlArray);
    }

    public function method()
    {
        return $this->requestType;
    }
}
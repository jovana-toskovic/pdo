<?php

namespace App\Core;
use Exception;

class Request
{
    private $requestType;

    private function request($requestType, $urlArray)
    {

        if($requestType === 'GET' || $requestType === 'DELETE') {
            if($requestType === 'GET') {
                array_splice( $urlArray, 1, 0, 'index');
            }
            $_REQUEST = array_key_exists(2, $urlArray) ? ['id' => $urlArray[2]] : [];
        }

        if($requestType === 'PUT') {
            parse_str(file_get_contents("php://input"), $_PUT);
            $_REQUEST = $_PUT;

            if ($urlArray[2] !== $_REQUEST['id']) {
                throw new Exception('Id does not match.');
            }
        }

        if($requestType === 'POST') {
            $_REQUEST = $_POST;
        }

        $model = $urlArray[0];
        $path = "$urlArray[0]/$urlArray[1]";
        return ['path' => $path, 'arguments' => $_REQUEST, 'model' => $model];
    }

    public function uri()
    {
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $urlArray = explode('/', $uri);

       return $this->request($this->requestType, $urlArray);

    }

    public function method()
    {
        return $this->requestType;
    }
}
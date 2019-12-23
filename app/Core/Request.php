<?php

namespace App\Core;
use Exception;

class Request
{
    private $requestType;

    private function request($urlArray)
    {
        $request = [];
        $action = array_key_exists(1, $urlArray) ? $urlArray[1] : 'index';

        if($this->requestType === 'GET' || $this->requestType === 'DELETE') {
            if($urlArray[0] === '') {
                $urlArray[0] = 'home';
            }
            array_splice($urlArray, 1, 0, 'index');
            if(array_key_exists(2, $urlArray)
                && ($urlArray[2] === 'edit'
                    || $urlArray[2] === 'create'
                    || $urlArray[2] === 'delete'
                )) {
                unset($urlArray[1]);
                $urlArray = array_values($urlArray);
            }
            $action = $urlArray[1];
            $request = array_key_exists(2, $urlArray) ? ['id' => $urlArray[2]] : [];
            if($urlArray[1] === 'edit') {
                $action = 'update';
            }
            if($urlArray[1] === 'create') {
                $action = 'store';
            }
        }

        if($this->requestType === 'POST') {
            $request = $_POST;
            if (array_key_exists('_METHOD', $request) && $request['_METHOD'] === 'PUT'){
                $this->requestType = 'PUT';
            }
        }

        if($this->requestType === 'PUT') {
            parse_str(file_get_contents("php://input"), $_PUT);
            $request = $_PUT;
            unset($request['_METHOD']);
        }

        $path = "$urlArray[0]/$urlArray[1]";

        return ['path' => $path, 'arguments' => $request, 'action'=>$action];
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
<?php

namespace App\Core;
use Exception;

class Request
{
    private $requestType;

    private function request($urlArray)
    {
        // print_r($urlArray);
        $request = [];
        $action = array_key_exists(1, $urlArray) ? $urlArray[1] : 'index';

        if($this->requestType === 'GET') {
            if(array_key_exists(1, $urlArray) && is_numeric($urlArray[1])) {
                // echo $urlArray[1];
                $action = 'show';
                $request = ['id' => $urlArray[1]];
                $urlArray[1] = 'id';
                if (array_key_exists(2, $urlArray)) {
                    $action = 'edit';
                }
            }

            if(array_key_exists(0, $urlArray) && ($urlArray[0] === 'login' ||  $urlArray[0] === 'register')) {
                $action = 'show' . ucfirst($urlArray[0]) . 'Form';
            }
        }

        if($this->requestType === 'POST') {
            $request = $_POST;
            $action = "store";
            if (
                $urlArray[0] === 'login' ||  
                $urlArray[0] === 'register' ||
                $urlArray[0] === 'logout'
            ) {
                $action = $urlArray[0];
            }
            if (array_key_exists('_METHOD', $request) &&
                ($request['_METHOD'] === 'PUT' || $request['_METHOD'] === 'DELETE')
            ){
                $this->requestType = $request['_METHOD'];
            }
        }

        if($this->requestType === 'PUT') {
            parse_str(file_get_contents("php://input"), $_PUT);
            $request = $_PUT;
            $action = 'update';
            $urlArray[1] = 'id';
            unset($request['_METHOD']);
        }

        if ($this->requestType === 'DELETE') {
            $action = 'destroy';
            $request = ['id' => $urlArray[1]];
            $urlArray[1] = 'id';
        }

        $path = $urlArray[0];
        if (array_key_exists(1, $urlArray)){
            $path = "$urlArray[0]/$urlArray[1]";
        }
        if (array_key_exists(2, $urlArray)){
            $path = "$urlArray[0]/$urlArray[1]/$urlArray[2]";
        }
//
//             echo $path;
//             print_r($request);
//             echo $action;

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
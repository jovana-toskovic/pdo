<?php

namespace App\Classes;

class Session
{
    public function setStoredValue(array $params)
    {
        foreach ($params as $key => $value) {
            if(isset($_SESSION)) {
                $_SESSION[$key] = $value;
            }
        }
    }

    public function getStoredValue(string $key)
    {
        if(isset($_SESSION)) {
            return $_SESSION[$key];
        }
    }

    public function startSession()
    {
        session_start();
    }

    public function destroySession()
    {
        session_destroy();
    }
}

<?php

namespace App\Classes;

class Session
{

    public function __construct($arg)
    {
        $this->startSession();
        $this->setStoredValue($arg);
    }

    public function setStoredValue(array $params)
    {
        foreach ($params as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function getStoredValue(string $key)
    {
        return $_SESSION[$key];
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

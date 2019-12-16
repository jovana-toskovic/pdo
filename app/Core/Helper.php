<?php

namespace App\Core;

class Helper
{
    public static $argument;

    public static function get($argument)
    {
        static::$argument = $argument;
    }

    public static function return()
    {
        return static::$argument;
    }
}

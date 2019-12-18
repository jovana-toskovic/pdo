<?php

namespace App\Core;

use App\Classes\QueryBuilder;

class DB
{
    private static $db;

    public static function get(QueryBuilder $db)
    {
        static::$db  = $db;
    }

    public static function return()
    {
        return static::$db;
    }
}

<?php

namespace App\Core;

use App\Classes\QueryBuilder;

class Helper
{
    private static $db;

    public static function getDB(QueryBuilder $db)
    {
        static::$db  = $db;
    }

    public static function returnDB()
    {
        return static::$db;
    }
}

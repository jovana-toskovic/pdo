<?php

namespace App\Libs;

class PageHelper
{
    public static function displayPage($viewName)
    {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        return  $root . '/../views/' . $viewName;
    }
}

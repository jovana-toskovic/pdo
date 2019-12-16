<?php

namespace App\Classes\Errors;

use Exception;

class QueryBuilderException extends Exception
{
    public $code;
}

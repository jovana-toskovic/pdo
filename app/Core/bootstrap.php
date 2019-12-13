<?php

use App\Classes\DBConnection;
use App\Classes\QueryBuilder;
use App\Classes\Validation\Validator;
use App\Core\Router;

$router = new Router();

require_once __DIR__ . '/routes.php';


$db = new QueryBuilder(
    DBConnection::getInstance()->getConnection(),
    new Validator()
);



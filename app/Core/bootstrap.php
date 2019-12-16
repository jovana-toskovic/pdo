<?php

use App\Classes\DBConnection;
use App\Classes\QueryBuilder;
use App\Classes\Validation\Validator;
use App\Core\Router;

// ovde nam treba constanta BASIC_PATH

$router = new Router();

require_once __DIR__ . '/routes.php';


$db = new QueryBuilder(
    DBConnection::getInstance()->getConnection(),
    new Validator()
);



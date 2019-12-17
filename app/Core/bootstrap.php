<?php

use App\Classes\DBConnection;
use App\Classes\QueryBuilder;
use App\Classes\Validation\Validator;
use App\Core\Router;
use App\Core\Helper;

define('BASIC_PATH', __DIR__ . '/../../');


$router = new Router();

require_once __DIR__ . '/routes.php';
$config = require __DIR__ . '/config.php';
$config = $config['database'];

$db = new QueryBuilder(
    DBConnection::getInstance($config)->getConnection(),
    new Validator()
);

Helper::getDB($db);



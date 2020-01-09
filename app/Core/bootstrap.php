<?php

use App\Classes\DBConnection;
use App\Classes\QueryBuilder;
use App\Classes\Validation\QueryBuilderValidator;
use App\Core\Router;
use App\Core\DB;

define('BASIC_PATH', __DIR__ . '/../../');
define('URL_PATH', 'http://pdo.test/');

$router = new Router();

require_once __DIR__ . '/routes.php';
$config = require __DIR__ . '/config.php';
$config = $config['database'];

$db = new QueryBuilder(
    DBConnection::getInstance($config)->getConnection(),
    new QueryBuilderValidator()
);

DB::get($db);

<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Core/bootstrap.php';

use App\Core\Request;

$url =  new Request();
$router->direct($url->uri(), $url->method());

$_SESSION['id'] = '1';
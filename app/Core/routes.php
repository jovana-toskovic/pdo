<?php

use App\Core\Router;
use App\Controllers\Controller;

// sto se tice ovih url adresa mozda je najbolje da one ovako izgleajiu /posts/index
$router->get("posts/index", "App\Controllers\Controller@index");
$router->put("posts/edit", "App\Controllers\Controller@edit");
$router->post("posts/create", "App\Controllers\Controller@create");
$router->delete("posts/delete", "App\Controllers\Controller@delete");
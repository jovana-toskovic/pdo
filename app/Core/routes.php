<?php

$router->get("posts/index", "App\Controllers\Controller@index");
$router->get("posts/edit", "App\Controllers\Controller@edit");
$router->get("posts/create", "App\Controllers\Controller@create");

$router->put("posts/edit", "App\Controllers\Controller@edit");
$router->post("posts/create", "App\Controllers\Controller@create");
$router->delete("posts/delete", "App\Controllers\Controller@delete");
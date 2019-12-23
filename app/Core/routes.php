<?php
// ROOT
$router->get("home/index", "App\Controllers\HomeController@index");

// POSTS
$router->get("posts/index", "App\Controllers\PostController@index");
$router->get("posts/edit", "App\Controllers\PostController@edit");
$router->get("posts/create", "App\Controllers\PostController@create");

$router->put("posts/edit", "App\Controllers\PostController@edit");
$router->post("posts/create", "App\Controllers\PostController@create");
$router->delete("posts/delete", "App\Controllers\PostController@delete");

// USERS
$router->get("users/index", "App\Controllers\UserController@index");
$router->get("users/edit", "App\Controllers\UserController@edit");
$router->get("users/create", "App\Controllers\UserController@create");

$router->put("users/edit", "App\Controllers\UserController@edit");
$router->post("users/create", "App\Controllers\UserController@create");
$router->delete("users/delete", "App\Controllers\UserController@delete");
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
$router->get("register/index", "App\Controllers\RegistrationController@index");
$router->get("login/index", "App\Controllers\LoginController@index");

$router->put("users/edit", "App\Controllers\UserController@edit");
$router->post("register/create", "App\Controllers\RegistrationController@create");
$router->post("login/create", "App\Controllers\LoginController@create");
$router->delete("users/delete", "App\Controllers\UserController@delete");

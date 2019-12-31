<?php
// ROOT
$router->get("home/index", "App\Controllers\HomeController@index");

// POSTS
$router->get("posts", "App\Controllers\PostController@index");
$router->get("posts/id", "App\Controllers\PostController@show");
$router->get("posts/id/edit", "App\Controllers\PostController@edit");
$router->get("posts/create", "App\Controllers\PostController@create");

$router->put("posts/id", "App\Controllers\PostController@update");
$router->post("posts", "App\Controllers\PostController@store");
$router->delete("posts/id", "App\Controllers\PostController@destroy");

// USERS
$router->get("users", "App\Controllers\UserController@index");
$router->get("users/id", "App\Controllers\UserController@show");
$router->get("users/id/edit", "App\Controllers\UserController@edit");

$router->get("register/index", "App\Controllers\RegistrationController@index");
$router->get("login/index", "App\Controllers\LoginController@index");

$router->put("users/id", "App\Controllers\UserController@update");
$router->delete("users/id", "App\Controllers\UserController@destroy");

$router->post("register/create", "App\Controllers\RegistrationController@create");
$router->post("login/create", "App\Controllers\LoginController@create");



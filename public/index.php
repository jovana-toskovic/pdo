<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Core/bootstrap.php';

use App\Core\Request;

$url =  new Request();
$router->direct($url->uri(), $url->method() );


//$objects = $query->table(new Post)->where(['id', '=', 10])->orWhere(['author', 'LIKE', 'Anna'])->where(['id', '=', 9])->get();
//
//echo "<br>";
//
//foreach($objects as $object){
//    print_r($object);
//}
//
//echo "<br>";
//echo "<br>";
//
//$objects1 = $query->table(new Post)->where(['id' => 9, 'author' => 'Anna'])->orWhere(['author', 'LIKE', 'Michael'])->get();
//
//echo "<br>";
//
//foreach($objects1 as $object){
//    print_r($object);
//}
//
//echo "<br>";
//echo "<br>";

//$insert = $query->table(new Post)->insert(['title'=>'Title', 'body'=>'Some text', 'author'=>'Michael', 'created_at'=> date("Y-m-d H:i:s"), 'published' => true]);
//$update = $query->table(new Post)->where(['id' => 19])->update(['author'=>'Marc']);
//$delete = $query->table(new Post)->where(['id' => 16])->delete();


//da li baza ima prosledjena polja
// da li je element na 1. indexu like, =, !=,
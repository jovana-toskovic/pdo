<?php

require __DIR__ . '/vendor/autoload.php';
// require ('core/init.php')

use App\Classes\Post;
use App\Classes\Model;
use App\Classes\QueryBuilder;


$query = new QueryBuilder();

// App::bind('config', require('config.php'));

// App::resolve('config');

// $posts = Post::where(['id', 17])->get();


//$objects = $query->table(new Post)->getAll();

$objects = $query->table(new Post)->where(['id', '=', 10])->orWhere(['author', 'LIKE', 'Anna'])->where(['id', '=', 9])->get();

echo "<br>";

foreach($objects as $object){
    print_r($object);
}
echo "<br>";
echo "<br>";

$objects1 = $query->table(new Post)->where(['id' => 9, 'author' => 'Anna'])->orWhere(['author', 'LIKE', 'Michael'])->get();

echo "<br>";

foreach($objects1 as $object){
    print_r($object);
}

echo "<br>";
echo "<br>";

//$insert = $query->table(new Post)->insert(['title'=>'Title', 'body'=>'Some text', 'author'=>'Michael', 'created_at'=> date("Y-m-d H:i:s"), 'published' => true]);

//$update = $query->table(new Post)->where(['id' => 19])->update(['author'=>'Marc']);
// $delete = $query->table(new Post)->where(['id' => 16])->delete();

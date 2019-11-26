<?php

require __DIR__ . '/vendor/autoload.php';

use App\Classes\DBConnection;
use App\Classes\Guestbook;

$instance = DBConnection::getInstance();

// $collection = $instance->get('posts', "CLASS", Guestbook::class);
// foreach($collection as $object){
//     echo "<p>" . htmlspecialchars($object->entry) . "</p>";
// }
// echo "<p>" . htmlspecialchars($collection[0]->entry) . "</p>";

// $newStmt = $instance->runQuery('INSERT INTO posts (title, body, author, published, created_at) VALUES (?, ?, ?, ?, NOW());', array('New title', 'This is new post by Anna', 'Anna', true));

// $array = 
// $objectByCondition = $instance->table('posts')->where(["id" => 9, ">", "&&"])->where(["author" => "Anna", "LIKE"])->fetch("CLASS", Guestbook::class)->getAll();
// foreach($objectByCondition as $object){
//     echo "<p>ID: $object->id and AUTHOR: $object->author</p>";
// }

// $array = $instance->getAll('SELECT * FROM posts;', "num");
// print_r($array);


// $objectByCondition = $instance->table('posts')->where(["id" => 9, ">", "&&"])->where(["author" => "Anna", "LIKE"])->fetch("CLASS", Guestbook::class)->getAll();



$objects = $instance
->table('posts')
->select()
->where(['id', '>', 9])
->or()
->where(['author', 'LIKE', 'Carl'])
->fetch("CLASS", Guestbook::class)
->getAll();

foreach($objects as $object){
    echo "<p>ID: $object->id and AUTHOR: $object->author</p>";
}


// $objects1 = $instance
// ->table('posts')
// ->insert(['author', 'title', 'body'], ['Karlie', 'This is new title', 'This is post body'])
// ->post();

$objects2 = $instance
->table('posts')
->update(['author', 'title', 'body'], ['Carl', 'This is Carl.', 'This is post by Carl'])
->where(['id', '=', 11])
->post();
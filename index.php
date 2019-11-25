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


$objectByCondition = $instance->getAll('posts', ['id', 'body', 'title', 'author'], ['id'=>1, 'logicalOperator'=>'||',  'author'=>'Anna'], "CLASS", Guestbook::class);
foreach($objectByCondition as $object){
    echo "<p>ID: $object->id and AUTHOR: $object->author</p>";
}




// $array = $instance->getAll('SELECT * FROM posts;', "num");
// print_r($array);

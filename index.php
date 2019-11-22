<?php

require __DIR__ . '/vendor/autoload.php';

use App\Classes\DBConnection;
use App\Classes\Guestbook;

$instance = DBConnection::getInstance();

$collection = $instance->getAll('SELECT * FROM posts;', "CLASS", Guestbook::class);
foreach($collection as $object){
    echo "<p>" . htmlspecialchars($object->entry) . "</p>";
}
echo "<p>" . htmlspecialchars($collection[0]->entry) . "</p>";

// $newStmt = $instance->runQuery('INSERT INTO posts (title, body, author, published, created_at) VALUES (?, ?, ?, ?, NOW());', array('New title', 'This is new post by Dereck', 'Dereck', true));


$objectById = $instance->get('SELECT * FROM posts WHERE id = ?;', "CLASS", Guestbook::class, [1]);
foreach($objectById as $property=>$value){
    echo "<p>$property: $value</p>";
}


$array = $instance->getAll('SELECT * FROM posts;', "num");
print_r($array);

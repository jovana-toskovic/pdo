<?php

require __DIR__ . '/vendor/autoload.php';

use App\Classes\DBConnection;
use App\Classes\Guestbook;

$instance = DBConnection::getInstance();

$stmt = $instance->getQuery('SELECT * FROM posts;', 'App\Classes\Guestbook');

$collection = $stmt->fetchAll();

foreach($collection as $object){
    echo "<p>" . htmlspecialchars($object->entry) . "</p>";
}

echo "<p>" . htmlspecialchars($collection[0]->entry) . "</p>";

// $newStmt = $instance->runQuery('INSERT INTO posts (title, body, author, published, created_at) VALUES (?, ?, ?, ?, NOW());', array('New title', 'This is new post by Dereck', 'Dereck', true));
$stmt1 = $instance->getQuery('SELECT * FROM posts WHERE id = ?;', 'App\Classes\Guestbook', array('1'));
$objectById = $stmt1->fetch();
var_dump($objectById);
foreach($objectById as $property=>$value){
    echo "<p>$property: $value</p>";
}
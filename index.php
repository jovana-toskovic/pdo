<?php

require __DIR__ . '/vendor/autoload.php';

use App\Classes\DBConnection;
use App\Classes\Guestbook;

$instance = DBConnection::getInstance();

$stmt = $instance->getQuery('SELECT * FROM posts;', 'App\Classes\Guestbook');

while ($r = $stmt->fetch()){
    echo "<p>$r->entry</p>";
}
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Classes\Post;
use App\Classes\Model;
use App\Classes\QueryBuilder;

$query = new QueryBuilder();

// $collection = $instance->get('posts', "CLASS", Guestbook::class);
// foreach($collection as $object){
//     echo "<p>" . htmlspecialchars($object->entry) . "</p>";
// }
// echo "<p>" . htmlspecialchars($collection[0]->entry) . "</p>";

// $newStmt = $instance->runQuery('INSERT INTO posts (title, body, author, published, created_at) VALUES (?, ?, ?, ?, NOW());', array('New title', 'This is new post by Anna', 'Anna', true));


// $objectByCondition = $instance->table('posts')->where(["id" => 9, ">", "&&"])->where(["author" => "Anna", "LIKE"])->fetch("CLASS", Guestbook::class)->getAll();
// foreach($objectByCondition as $object){
//     echo "<p>ID: $object->id and AUTHOR: $object->author</p>";
// }

// $array = $instance->getAll('SELECT * FROM posts;', "num");
// print_r($array);

// $objectByCondition = $instance->table('posts')->where(["id" => 9, ">", "&&"])->where(["author" => "Anna", "LIKE"])->fetch("CLASS", Guestbook::class)->getAll();



// $objects = $query
// ->table(new Post)
// ->select()
// ->where(['id', '>', 9])
// ->or()
// ->where(['author', 'LIKE', 'Carl'])
// ->fetch("CLASS")
// ->getAll();

// $posts = Post::where(['id', 17])->get();


//$objects = $query->table(new Post)->getAll();
// ['id' => 1, 'name'=> 'jovana']
$objects = $query->table(new Post)->where(['id', '=', 10])->orWhere(['author', 'LIKE', 'Anna'])->where(['id', '=', 9])->get();

echo "<br>";

foreach($objects as $object){
    print_r($object);
}
echo "<br>";
echo "<br>";

$objects1 = $query->table(new Post)->where(['id' => 9, 'author' => 'Anna'])->orWhere(['author', 'LIKE', 'Marc'])->get();

echo "<br>";

foreach($objects1 as $object){
    print_r($object);
}

echo "<br>";
echo "<br>";

// $insert = $query->table(new Post)->insert(['title'=>'Title', 'body'=>'Some text', 'author'=>'Michael', 'created_at'=> date("Y-m-d H:i:s"), 'published' => true]);

// $update = $query->table(new Post)->where(['id' => 19])->update(['author'=>'Marc']);
// $delete = $query->table(new Post)->where(['id' => 16])->delete();



// $posts = new Post();
// $object = $posts->

// $objects1 = $instance
// ->table('posts')
// ->insert(['author', 'title', 'body'], ['Karlie', 'This is new title', 'This is post body'])
// ->post();

// $objects2 = $instance
// ->table('posts')
// ->update(['author', 'title', 'body'], ['Carl', 'This is Carl.', 'This is post by Carl'])
// ->where(['id', '=', 11])
// ->post();

// $objects3 = $instance
// ->table('posts')
// ->delete()
// ->where(['id', '=', 12])
// ->post();

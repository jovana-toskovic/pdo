<?php

namespace App\Classes;
use App\Contracts\ModelInterface;

class Post implements ModelInterface
{
    private $id, $title, $body, $author, $published, $created_at;
    private $columnNames = Array("id", "title", "body", "author", "published", "created_at");
    public $entry;
    public $table = 'posts';

    public function __construct()
    {
        $this->entry = "{$this->author} posted: {$this->body}";
    }

    public function getTableName(): string
    {
        return $this->table;
    }

    public function getModelProperties()
    {
        return $this->columnNames;
    }
}


//class Validator {
//    private $errors = [];
//
//    private function isValueValid() {
//
//        $error[] = "Value is not valid";
//    }
//
//    private function isColumnValid() {
//
//    }
//
//    public function validate() {
//        if ()
//    }
//}
<?php

namespace App\Classes;
use App\Contracts\ModelInterface;

class Post implements ModelInterface
{
    public $id, $user_id;
    public $title, $body, $created_at, $username;
    private $columnNames = Array("id", "title", "body", "published", "created_at", "user_id", 'posts.id');
    public $table = 'posts';

    public function __construct()
    {
//        $this->author = "{$this->username}";
    }

    public function getTableName(): string
    {
        return $this->table;
    }

    public function getColumnNames()
    {
        return $this->columnNames;
    }
}

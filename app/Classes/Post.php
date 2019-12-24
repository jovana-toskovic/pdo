<?php

namespace App\Classes;
use App\Contracts\ModelInterface;

class Post implements ModelInterface
{
    public $id, $user_id;
    public $title, $body, $created_at;
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

    public function getColumnNames()
    {
        return $this->columnNames;
    }
}

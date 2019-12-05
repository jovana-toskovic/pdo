<?php

namespace App\Classes;
use App\Contracts\ModelInterface;

class Post implements ModelInterface
{
    public $id, $title, $body, $author, $published, $created_at, $entry;
    public $table = 'posts';

    public function __construct()
    {
        $this->entry = "{$this->author} posted: {$this->body}";
    }

    public function getTableName(): string
    {
        return $this->table;
    }
}

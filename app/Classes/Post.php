<?php

namespace App\Classes;

use App\Classes\Model;
use App\Contracts\ConnectionInterface;

class Post 
{
    public $id, $title, $body, $author, $published, $created_at, $entry;
    public $table = 'posts';

    public function __construct()
    {
        $this->entry = "{$this->author} posted: {$this->body}";
    }

    public function getTableName()
    {
        return $this->table;
    }
}

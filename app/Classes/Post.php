<?php

namespace App\Classes;

use App\Classes\Model;
use App\Contracts\ConnectionInterface;

class Post 
{
    // NOTE: polja treba da smestimo u nizu
    public $id, $title, $body, $author, $published, $created_at, $entry;
    public $table = 'posts';

    public function __construct()
    {
        $this->entry = "{$this->author} posted: {$this->body}";
    }

    // NOTE: getTableName treba da bude abstraktna metoda nasledjena iz model klase ili da bude vezana za intrfejs
    public function getTableName()
    {
        return $this->table;
    }
}
